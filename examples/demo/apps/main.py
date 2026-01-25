import json
import sys
from integration.spython import start
from integration.spython import sphpcom

def callbackmain():
    global n
    #sphpcom.callSphpEvent("sdp","call back")

def OnFunCall(fname,fdata):
    if fname == "genimg":
        sphpcom.console.log("on function call input")
        sphpcom.callSphpEvent("reply","Hello from Python")

def OnCmdCall(cmd):
    if cmd == "quit":
        start.QuitMe()
    sphpcom.console.log(f"cmd call: {cmd}")

def main():    
    start.runme(callbackmain,OnFunCall,OnCmdCall)

main()
