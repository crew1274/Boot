import logging
import asyncio
import os
from hbmqtt.client import MQTTClient, ClientException
from hbmqtt.mqtt.constants import QOS_1, QOS_2

logger = logging.getLogger(__name__)
#MQTT Server IP
url = 'mqtt://140.116.39.225:1883'

topic = '/test'
web_dist = '/var/www/html/web'

@asyncio.coroutine
def uptime_coro():
    C = MQTTClient()
    yield from C.connect(url)
    yield from C.subscribe([(topic, QOS_1),(topic, QOS_2)],)
    logger.info("Subscribed")
    i=1
    try:
        while i:
            message = yield from C.deliver_message()
            packet = message.publish_packet
            command(packet.variable_header.topic_name,packet.payload.data)
            print(packet.payload.data)
            print("%d: %s => %s" % (i, packet.variable_header.topic_name, str(packet.payload.data)))
            i=i+1
        yield from C.unsubscribe([topic,topic])
        logger.info("UnSubscribed")
        yield from C.disconnect()
    except ClientException as ce:
        logger.error("Client exception: %s" % ce)

def command(topic,recv):
    #print("exec")
    if(recv == bytearray(b'down')):
        os.system('php %s/artisan down'%(web_dist))
        logger.info("Web Down")
    if(recv == bytearray(b'up')):
        os.system('php %s/artisan up'%(web_dist))
        logger.info("Web Up")
    if(recv == bytearray(b'upgrade')):
        os.system('cd  %s && git pull'%(web_dist))
        logger.info("upgrade")
        
if __name__ == '__main__':
    formatter = "[%(asctime)s] {%(filename)s:%(lineno)d} %(levelname)s - %(message)s"
    logging.basicConfig(level=logging.INFO, format=formatter)
    #logging.basicConfig(level=logging.DEBUG, format=formatter, filename='log_sub.txt')
    #執行
    asyncio.get_event_loop().run_until_complete(uptime_coro())