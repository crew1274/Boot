#encoding=utf-8

import serial as pyserial
import gpio as GPIO
import time
import array

from dae.lib.crc16 import getCRC16


class ModbusSerial:
    # set baudrate and port and timeout
    # nanopi rs485 port is /dev/ttyS1 and tr pin number is 6
    def __init__(self, baudrate=9600, port='/dev/ttyS1', timeout=1, tr=6):
        self.tr = tr
        # initialize pyserial 
        self.serial = pyserial.Serial(
            port = port,
            timeout = timeout,
            baudrate = baudrate
        )
        # if serial is not open, open it.
        if not self.serial.isOpen():
            self.serial.Open()

        # initialize GPIO
        GPIO.setwarnings(False)
        GPIO.setmode(GPIO.BCM)
        GPIO.setup(self.tr, 'out')


    # 中控 -> CC2030 : 1,3,96,0,0,2,CRC,CRC
    # CC2030 -> 中控 : 1,3,4,LH,LL,HH,HL,CRC,CRC
    # 用來讀寫通訊位址資料表
    # (List)
    def writeCommandToModbus(self, data):
        # delay
        time.sleep(.02)
        ser = self.serial
        dataList = getCRC16(data)
        # write
        GPIO.set(self.tr, 0)
        ser.write(dataList)
        ser.flush()

        # read
        GPIO.set(self.tr, 1)
        # the first three numbers for the fixed code, the last two numbers CRC code
        words = dataList[5] # words length
        length = 3 + words * 2 + 2
        response = ser.read(length) # send command to meter and get response
        # Convert hex string to array
        response = array.array('B', response)

        return response


    def close(self):
        self.serial.close()
