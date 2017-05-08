#encoding=utf-8

import sqlite3
import time
import dae.lib.common as common
from dae.lib.path import *

class SQLite:
    def __init__(self):
        super(SQLite, self).__init__()
        self.conn = sqlite3.connect(SERVER_DATABASE_PATH)
        self.conn.row_factory = sqlite3.Row


    def querySettingsByAddAndCH(self, address, channel):
        time.sleep(.2)
        conn = self.conn
        tableName = 'boot_settings'
        state = "SELECT * FROM {0} WHERE address={1} and circuit={2}".format(tableName, address, channel)
        cursor = conn.execute(state)
        output = []

        for row in cursor:
            model = row['model']
            code = self.queryCodes(model)
            codeSplit = code.split(',')
            codeH = int(codeSplit[0])
            codeL = int(codeSplit[1])
            address = row['address']
            ch = row['ch']
            speed = row['speed']
            baudrate = self.convertSpeedToNumber(speed)
            circuit = row['circuit']
            setting = {
                'model': model,
                'speed': speed,
                'codeH': codeH,
                'codeL': codeL,
                'address': address,
                'ch': ch,
                'baudrate': baudrate,
                'circuit': circuit
            }
            output.append(setting)

        return output


    """
    get meter settings from web
    """
    def querySettings(self):
        time.sleep(.2)
        conn = self.conn
        tableName = 'boot_settings'
        state = "SELECT * FROM {0}".format(tableName)
        cursor = conn.execute(state)

        output = []

        for row in cursor:
            model = row['model']
            code = self.queryCodes(model)
            codeSplit = code.split(',')
            codeH = int(codeSplit[0])
            codeL = int(codeSplit[1])
            address = row['address']
            ch = row['ch']
            speed = row['speed']
            baudrate = self.convertSpeedToNumber(speed)
            circuit = row['circuit']
            setting = {
                'model': model,
                'speed': speed,
                'codeH': codeH,
                'codeL': codeL,
                'address': address,
                'ch': ch,
                'baudrate': baudrate,
                'circuit': circuit
            }
            output.append(setting)

        return output


    """
    get number by baudrate
    """
    def convertSpeedToNumber(self, speed):
        if speed == 1200:
            return 1

        if speed == 2400:
            return 2

        if speed == 4800:
            return 3

        if speed == 9600:
            return 4


    """
    get machine codes
    """
    def queryCodes(self, model):
        conn = self.conn
        tableName = 'codes'
        state = "SELECT * FROM {0} WHERE {1}='{2}'".format(tableName, 'model', model)
        cursor = conn.execute(state)
        obj = cursor.fetchone()

        return obj['code']


    """
    get meter table data
    """
    def getMeterTable(self, model):
        conn = sqlite3.connect(METER_DATABASE_PATH)
        conn.row_factory = sqlite3.Row
        machineSplit = model.split('-')
        tableName = machineSplit[0]
        state = "SELECT * FROM {0}".format(tableName)
        cursor = conn.execute(state)

        return cursor


    def close(self):
        self.conn.close()
