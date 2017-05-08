#encoding=utf-8
import time
import requests

import dae.sqlite as sqlite
import dae.serial as serial
import dae.lib.common as common


def main():
    try:
        dbconn = sqlite.SQLite() # craete sqlite with server
        settings = dbconn.querySettings() # get meter settings
        gateways = []

        for row in settings:
            codeH = row['codeH']
            codeL = row['codeL']
            data = {
                'name': row['model'],
                'code': [codeH, codeL],
                'address': row['address'],
                'channel': row['ch'],
                'baud': row['baudrate']
            }

            gateways.append(data)

        output = {
            'd': 'set-meter',
            'gateways': gateways
        }

        response = common.postDataToServer(output)

        while True:
            setting = common.getServerSettings()
            isRun = setting['isRUN']
            configGap = setting['config_gap']
            port = setting['port']
            ip = setting['ip']

            isRun = common.isUpdateDeviceStatus()
            version = 'A01'
            net = 'Wan'
            model = 'Nanopi'

            output = {
                'd': 'update-ip',
                'ip': ip,
                'port': port,
                'net': net,
                'model': model,
                'version': version,
                'reboot': common.getBootCode()
            }

            if isRun:
                common.postDataToServer(output)
                time.sleep(int(configGap))
            else:
                time.sleep(1)

    except KeyboardInterrupt:
        pass

    except requests.exceptions.Timeout:
        common.rewriteConnectTimes()

    except:
        print("SOMETHING HAD ERROR")

    finally:
        dbconn.close()


if __name__ == '__main__':
    main()
