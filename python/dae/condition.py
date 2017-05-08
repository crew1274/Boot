import threading
import time

class Condition(threading.Thread):
    def __init__(self):
        super(Condition, self).__init__()
        self.cond = threading.Condition()
        self.isWait = False

    def changeWaitStatus(self):
        self.isWait = False if self.isWait else True

    def getCondition(self):
        return self.cond

    def acquire(self):
        self.cond.acquire()

    def notify(self):
        self.cond.notify()

    def wait(self):
        self.cond.wait()

    def release(self):
        self.cond.release()
