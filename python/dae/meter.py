import threading
import time
import requests
import json

import dae.lib.common as common
import dae.serial as serial
import dae.sqlite as sqlite
import dae.condition as condition

DATABUFF = []

class Meter(threading.Thread):
    # threading condition, rs485 port, rs485 tr ping number, baudrate
    def __init__(self, cond, port="/dev/ttyS1", trPin=6, baudrate=9600):
        super(Meter, self).__init__()
        self.port = port
        self.trPin = trPin
        self.baudrate = baudrate
        self.cond = cond
        self.serial = serial.ModbusSerial(port=self.port, tr=self.trPin, baudrate=self.baudrate)

    # Read data
    def run(self):
        self.cond.acquire()

        try:
            # read data loop start
            while True:
                config = common.getServerSettings()
                # post data to server time gap
                recordGap = int(config['record_gap'])
                readDataFromMeter(self)
                time.sleep(recordGap)

            # read data loop end
                        
        except KeyboardInterrupt:
            print("KeyboardInterrupt")

        except requests.exceptions.Timeout:
            common.rewriteConnectTimes()

        except:
            print("SOMETHING HAS ERROR")

        finally:
            self.serial.close()


class CommandMeter(threading.Thread):
    def __init__(self, cond, address, channel, port="/dev/ttyS1", trPin=6, baudrate=9600):
        super(CommandMeter, self).__init__()
        self.port = port
        self.trPin = trPin
        self.baudrate = baudrate
        self.cond = cond
        self.address = address
        self.channel = channel
        self.serial = serial.ModbusSerial(port=self.port, tr=self.trPin, baudrate=self.baudrate)
        self.data = ""

    def run(self):
        # execute first
        self.cond.changeWaitStatus()
        self.cond.acquire()
        self.cond.notify()

        # send data to server by command
        self.data = readDataFromMeter(self)
        # release lock
        self.cond.changeWaitStatus()
        self.cond.release()

    def getData(self):
        return self.data


def readDataFromMeter(self):
    # get meter settings from web database
    dbconn = sqlite.SQLite() # diff sqlite connnect 

    # 如果是執行命令讀取電表,則讀取指定迴路跟位址之電表即可（某台）
    if type(self) is CommandMeter:
        meterSettings = dbconn.querySettingsByAddAndCH(self.address, self.channel)
    # 讀取所有電表的資料
    elif type(self) is Meter:
        meterSettings = dbconn.querySettings()
    else:
        return

    # meterSettings loop start
    for config in meterSettings:
        model = config['model']
        address = config['address']
        ch = config['circuit']
        cursor = dbconn.getMeterTable(model)
        databuff = []
        output = []

        # cursor loop start
        for row in cursor:
            meterType = row['type']
            startAddress = row['start_address']
            tableLength = row['table_length']
            channelNumbers = row['channel_numbers']
            channelLength = row['channel_length']
            phaseNumbers = row['phase_numbers']
            phaseLength = row['phase_length']
            point1 = row['point_1']
            point2 = row['point_2']
            point3 = row['point_3']
            point4 = row['point_4']
            point5 = row['point_5']
            point6 = row['point_6']
            point7 = row['point_7']
            pointArray = [point1, point2, point3, point4, point5, point6, point7]
            pointNumber = 0
            for p in pointArray:
                if p is None:
                    break

                pointNumber = pointNumber + 1

            unit1 = row['unit_1']
            unit2 = row['unit_2']
            unit3 = row['unit_3']
            unit4 = row['unit_4']
            unit5 = row['unit_5']
            unit6 = row['unit_6']
            unit7 = row['unit_7']
            unitArray = [unit1, unit2, unit3, unit4, unit5, unit6, unit7]
            unitNumber = 0
            for u in unitArray:
                if u is None:
                    break

                unitNumber = unitNumber + 1

            descriptionArray = row['description_array'].split(',')
            position = int(startAddress) + ((ch - 1) * channelLength)
            length = phaseNumbers * phaseLength
            codeH = int(position / 256)
            codeL = int(position % 256)

            # if receive command
            if type(self) is Meter and self.cond.isWait:
                # stop threading
                self.cond.wait()

            # continue read data
            command = [address, 3, codeH, codeL, 0, length]
            response = self.serial.writeCommandToModbus(command)
            time.sleep(.5)

            for i in range(3, len(response) - 2, phaseLength * 2):
                LH = response[i]
                LL = response[i + 1]
                HH = response[i + 2]
                HL = response[i + 3]
                index = int((i - 3) / (phaseLength * 2)) # description array index
                unitIndex = index if unitNumber > 1 else 0
                pointIndex = index if pointNumber > 1 else 0
                total = round(int(LH * 256 + LL + HH * 256 * 256 * 256 + HL * 256 * 256 ) * pointArray[pointIndex], 2)
                temp =  {
                    'datetime': common.getNow(),
                    'address': address,
                    'channel': ch,
                    'register': [codeH, codeL],
                    'unit': unitArray[unitIndex],
                    'value': total,
                    'description': descriptionArray[index]
                }
                output.append(temp)

            databuff.extend(response)

        #cursor loop end

        data = {
            'd': 'data',
            'data': output
        }

        if type(self) is Meter:
            response = common.postDataToServer(data)
        elif type(self) is CommandMeter:
            # 如果想要使用task的方式回傳指令所要求的電表資料 則將此行註解 就不會自動回傳資料給server
            response = common.postDataToServer(data)
            # 回傳data的資料 為了讓task使用
            return data
    # meterSettings loop end
