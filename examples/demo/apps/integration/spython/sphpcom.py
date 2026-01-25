import json
from . import funlib

sfunLib = funlib.FunLib()

def consoleLog(msg="", jsonm="", type="l"):
    str1 = {
        "id": 1,
        "msg": msg,
        "type": type,
        "cpdata": jsonm
    }
    print(json.dumps(str1))

class sconsoleLog:
    def log(self, msg, jsonm="", type="l"):
        consoleLog(msg, jsonm, type)

    def info(self, msg, jsonm="", type="i"):
        consoleLog(msg, jsonm, "i")

    def warn(self, msg, jsonm="", type="w"):
        consoleLog(msg, jsonm, "w")

    def error(self, msg, jsonm="", type="e"):
        consoleLog(msg, jsonm, "e")

def callSphpEvent(evt,evtp,data={}):
    d = {}
    d["evt"] = evt
    d["evtp"] = evtp
    d["type"] = "c"
    d["bdata"] = data
    bdata = sfunLib.bin2hex(json.dumps(d))
    consoleLog("",bdata,"c")


console = sconsoleLog()
