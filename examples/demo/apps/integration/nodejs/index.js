const sphpdesk = require('sphpdesk');
const BasicApp = sphpdesk.BasicApp;

class index extends BasicApp{
    onstart(){
      this.debug.println("index app runing ");
    }
	
	async page_event_quitme(evtp){
        let mydata = {};
        mydata["app"] = "quit";
        this.sphp_api.getSphpCom().callSphpEvent("cquit","cquit",mydata);        
    }
	
    async page_new(){
        let myself = this;
        let mydata = {};
        mydata["app"] = "start";
        //this.sphp_api.getSphpCom().callSphpEvent("chk4","evtp",mydata);
        this.sphp_api.getSphpCom().callSphpEvent("reply","evtp",mydata);
        //this.debug.println("cwdir:- " + this.ServerPath);
    }
	
    async page_event_genimg(evtp){
        let myself = this;
		this.sphp_api.getSphpCom().callSphpEvent("reply","Hello From Node JS");
	}
	
	
}

const startEngine = sphpdesk.get_sphp_com();
//register apps
startEngine.registerApp("index",new index(startEngine));

// run listen
startEngine.runSphpCom();
startEngine.run(); // run default app index
