#encoding=utf-8
import time
import sys
import json
import threading
import requests

import dae.serial as serial
import dae.sqlite as sqlite
import dae.lib.common as common
import dae.condition as condition
from dae.meter import *
from dae.lib.path import *


def main():
    try:
        config = common.getServerSettings()
        # post data to server time gap
        configGap = int(config['config_gap'])
        # threading condition object
        cond = condition.Condition()
        meterThread = Meter(cond) # normal read meter data thread
        meterThread.start() # start read meter data thread
        i = 1

        while True:
            # get tasks
            time.sleep(configGap)
            response = common.getTasksFromServer()
            jsonResponse = json.loads(response.text)

            if jsonResponse == []:
                continue

            tasks = jsonResponse['tasks']
            finalExecute = 0
            taskOutput = []

            # execute every tasks
            for task in tasks:
                index = task['index']
                types = task['type']
                cmd = task['task']
                temp = {
                    'index': index,
                    'type': types,
                    'task': cmd
                }

                if cmd == 'reboot':
                    # 遠端下指令重新開機 先預留 回傳之後在執行
                    finalExecute = 1

                elif cmd == 'read':
                    # 執行command 得到指定address跟channel的電表資料（address/channel在網站不能有重複情況）
                    # 會依據address channel去找尋其對應的電表
                    # commandThread 執行後 會對meterThread插隊 優先執行commandThread 完畢後meterThread恢復執行
                    # {"d": "get-task", "tasks": [{"index": 32, "type": 25, "task": "read", "address": 1, "channel": 1}]}
                    channel = task['channel']
                    address = task['address']
                    commandThread = CommandMeter(cond, address, channel) # for command thread
                    commandThread.start()
                    time.sleep(10) # 延遲十秒 確保資料已讀取完畢
                    temp['data'] = commandThread.getData()

                elif cmd == 'download_settings':
                    # download settings
                    pass

                elif cmd == 'upgrade_version':
                    # upgrade version
                    pass

                else:
                    continue

                taskOutput.append(temp)


            output = {
                'd': 'get-task',
                'tasks': taskOutput
            }
            # post response to server
            common.postDataToServer(output)

            if finalExecute == 1:
                os.system('reboot')

    except:
        pass

    finally:
        pass


if __name__ == '__main__':
    main()

