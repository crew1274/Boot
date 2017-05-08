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
        recordGap = int(config['record_gap'])
        configGap = int(config['config_gap'])
        # threading condition object
        cond = condition.Condition()
        meterThread = Meter(cond) # normal read meter data thread
        meterThread.start() # start read meter data thread
        #time.sleep(5)
        # address = 2
        # channel = 1
        #commandThread = CommandMeter(cond, address, channel)
        #commandThread.start()

    except:
        pass

    finally:
        pass


if __name__ == '__main__':
    main()

