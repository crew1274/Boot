# coding: utf-8

import base64
import hashlib
import json
from Crypto.Cipher import AES
from dae.lib.path import *

def md5_hex(content, lower_case=False):
    m = hashlib.md5()
    m.update(str(content).encode('utf-8'))
    return m.hexdigest() if lower_case else m.hexdigest().upper()


def zero_padding(block_size, content_bytes):
    content_bytes += (chr(0) * (block_size - len(content_bytes) % block_size)).encode('utf-8')
    return content_bytes


def aes_encrypt(origin_key, content):
    content_bytes = zero_padding(AES.block_size, str(content).encode('utf-8'))
    key = md5_hex(origin_key)[16:]
    aes = AES.new(key.encode('utf-8'), AES.MODE_ECB)
    encrypt_content = str(base64.standard_b64encode(aes.encrypt(content_bytes)), 'utf-8')
    return encrypt_content


def aes_decrypt(origin_key, content):
    key = md5_hex(origin_key)[16:]
    aes = AES.new(key.encode('utf-8'), AES.MODE_ECB)
    decrypt_content = str(aes.decrypt(base64.standard_b64decode(str(content).encode('utf-8'))), 'utf-8').strip('\x00')
    return decrypt_content


def encryptData(data, func):
    key = getKey()

    if key == "":
        return data

    # add aes32 in final ""
    content = aes_encrypt(key, data) if func=="A16E" else ""

    return content


def decryptData(data, func):
    key = getKey()

    if key == "":
        return data

    # add aes32 in final ""
    content = aes_encrypt(key, data) if func=="A16E" else ""

    return content


def getKey():
    filename = SERVER_SETTINGS_PATH
    file = open(filename, 'r', encoding='utf-8')
    settings = file.read()
    mySettings = json.loads(settings)
    file.close()

    return mySettings['key']
