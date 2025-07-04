import json
import sys
import threading
import signal
import json
import queue
import time

from . import funlib
from . import sphpcom

sfunLib = funlib.FunLib()


#from snode.core.StartEngine import StartEngine
#StartEngine.runSphpCom()
#StartEngine.run()
blnrun = True
reader = None

def handle_sigint(sig, frame):
    global blnrun
    blnrun = False
    print("You pressed Ctrl+C!")    
    #sys.exit(0)

signal.signal(signal.SIGINT, handle_sigint)

def process_sphp_call(d,OnFunCall,OnCmdCall):
    #print(d)
    postdata = json.loads("[" + sfunLib.hex2bin(d) + "{}]")
    #postdata = json.loads(d)
    #sphpcom.console.log(postdata)
    #with open("data.json", "w") as f:
    #    json.dump(d, f)

    ipc = postdata[0]["response"]["ipc"]
    if "fun" in ipc:
        funm = ipc["fun"]
        alen1 = len(funm)
        for p in range(alen1):
            OnFunCall(funm[p]["aname"], funm[p]["data"])
            # print("you entered2: ", ipc["fun"][p])
    elif "cmd" in ipc:
        funm2 = ipc["cmd"]
        alen = len(funm2)
        for p2 in range(alen):
            #sphpcom.console.log(funm2)
            OnCmdCall(funm2[p2])

def QuitMe():
    global blnrun
    blnrun = False

            
def readInput(qu):
    global blnrun
    try:
        while blnrun:
            line = sys.stdin.readline().strip()
            if line:
                #sphpcom.console.log(line)
                qu.put(line)
                #break;
            time.sleep(0.01)
    except Exception as e:
        print(f"Error in stdin Python: {e}")  

def readInput3(qu):
    global blnrun
    buffer = b''
    
    try:
        while blnrun:
            time.sleep(1)
            # Read binary data in chunks
            chunk = sys.stdin.buffer.read(8192)
            if not chunk:  # EOF or no data
                continue
                
            buffer += chunk
            lines = buffer.split(b'\n')
            
            # Process all complete lines
            for line in lines[:-1]:
                try:
                    decoded = line.decode('utf-8').strip()
                    if decoded:
                        qu.put(decoded)
                except UnicodeDecodeError:
                    pass  # Handle encoding errors as needed
                    
            # Keep remaining partial line
            buffer = lines[-1]
            
    except Exception as e:
        print(f"Error in stdin Python: {e}")
    finally:
        # Process any remaining data
        if buffer.strip():
            try:
                qu.put(buffer.decode('utf-8').strip())
            except UnicodeDecodeError:
                pass

def runme(callback,OnFunCall,OnCmdCall):
    global blnrun
    try:
        q = queue.Queue()
        thread1 = threading.Thread(target=readInput, args=(q,))
        thread1.daemon = True
        thread1.start();
        while blnrun:
            time.sleep(0.01)
            callback()
            if not q.empty():
                line = q.get_nowait()
                process_sphp_call(line,OnFunCall,OnCmdCall)
            
            #if not thread1.is_alive():
            #    break;
                
    except  KeyboardInterrupt:
        pass
