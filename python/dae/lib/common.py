#encoding=utf-8
import json
import requests
import os.path
import socket
import datetime

# dae 
import dae.lib.crypto as mycry
from dae.lib.path import *


encoding = "utf-8"


def getServerSettings():
    filename = SERVER_SETTINGS_PATH
    file = open(filename, 'r', encoding=encoding)
    settings = file.read()
    mySettings = json.loads(settings)
    file.close()

    return mySettings;

def postDataToServer(data):
    settings = getServerSettings()
    serverIP = settings['ip']
    serverDomain = settings['domain']
    serverPort = settings['port']
    serverPath = settings['path']
    # encrypt data and format to json
    jData = json.dumps(data)
    encryptFunction = "A16E" # Now only A16E
    encryData = mycry.encryptData(jData, encryptFunction)
    ethernet = "eth0"
    url = "{0}:{1}/{2}?mac={3}&er={4}".format(serverDomain, serverPort, serverPath, getMac(ethernet), encryptFunction)
    response = requests.post(url, encryData, timeout=3)

def getTasksFromServer():
    settings = getServerSettings()
    serverIP = settings['ip']
    serverDomain = settings['domain']
    serverPort = settings['port']
    serverPath = settings['path']
    # encrypt data and format to json
    data = {
        'd': 'get-task'        
    }
    jData = json.dumps(data)
    encryptFunction = "A16E" # Now only A16E
    encryData = mycry.encryptData(jData, encryptFunction)
    ethernet = "eth0"
    url = "{0}:{1}/{2}?mac={3}&er={4}".format(serverDomain, serverPort, serverPath, getMac(ethernet), encryptFunction)
    response = requests.post(url, encryData, timeout=3)

    return response


def isUpdateDeviceStatus():
    settings = getServerSettings()
    isRun = settings['isRUN']

    return isRun


def parseResponseFromServer(response):
    deResponse = mycry.decryptData(response)
    jData = json.loads(deResponse)

    return jData


# get IP Address
def getIPAddress():
    return [(s.connect(('8.8.8.8', 53)), s.getsockname()[0], s.close()) for s in [socket.socket(socket.AF_INET, socket.SOCK_DGRAM)]][0][1]


# boot settings
def getBootSettings():
    filename = BOOT_CONFIG_PATH
    # create a new file if file not exists
    if not os.path.exists(filename):
        obj = {}
        obj['boot_code'] = 'M'
        obj['connect_times'] = 0
        
        file = open(filename, 'w', encoding=encoding)
        file.write(json.dumps(obj))
        file.close()

    file = open(filename, 'r', encoding=encoding)
    settings = file.read()
    mySettings = json.loads(settings)
    file.close()

    return mySettings;


def writeBootSetting(key, value):
    mySettings = getBootSettings()
    mySettings[key] = value
    file = open(BOOT_CONFIG_PATH, 'w', encoding=encoding)
    file.write(json.dumps(mySettings))
    file.close()


def writeBootCode(code):
    mySettings = getBootSettings()
    writeMySetting('boot_code', code)


def getBootCode():
    mySettings = getBootSettings()
    bootCode = mySettings['boot_code']

    return bootCode

# reboot if the connection fails 100 times
def rewriteConnectTimes(code=''):
    if not code == '':
        writeBootSetting('connect_times', 0)
        return 0

    isReboot = False
    mySettings = getBootSettings()
    times = mySettings['connect_times']

    times = int(times) + 1

    if times == 100:
        isReboot = True
        times = 0

    writeBootSetting('connect_times', times)

    if isReboot:
        writeBootCode('W')
        os.system('reboot')


# get now time
def getNow():
    return datetime.datetime.now().strftime('%Y-%m-%dT%H:%M:%S')


# get mac address
def getMac(interface):
    try:
        mac = open('/sys/class/net/' + interface + '/address').readline()

    except:
        mac = "00:00:00:00:00:00:"

    return mac[0:17]
