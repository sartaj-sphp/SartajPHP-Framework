<?php
/**
 * Description of VoiceReco
 *
 * @author sartaj
 * https://tutorialzine.com/2017/08/converting-from-speech-to-text-with-javascript
 */
class VoiceReco extends Sphp\Tools\Component{
    
    public function onjsrender() {
        //addFileLink($this->myUrl . "/voicereco.js");
        addHeaderJsFunctionCode('ready','spch'.$this->name, 'try {
  var SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
  var recognition = new SpeechRecognition();
}
catch(e) {
  console.error(e);
  $(\'.no-browser-support\').show();
  $(\'.voicereco\').hide();
}
var noteTextarea = $(\'#note-textarea\');
var instructions = $(\'#recording-instructions\');
var noteContent = \'\';
recognition.continuous = true;

recognition.onresult = function(event) {
  var current = event.resultIndex;
  var transcript = event.results[current][0].transcript;
  var mobileRepeatBug = (current == 1 && transcript == event.results[0][0].transcript);
  replyBack(transcript.trim().toLowerCase());
  if(!mobileRepeatBug) {
    noteContent += transcript;
    noteTextarea.val(noteContent);
  }
};

recognition.onstart = function() { 
    readOutLoud("I am ready to listen you");
  instructions.text(\'Activated. Try speaking into the microphone.\');
};

recognition.onspeechend = function() {
    readOutLoud("Bye Bye");
  instructions.text(\'You were quiet for a while turned itself off.\');
};

recognition.onerror = function(event) {
  if(event.error == \'no-speech\') {
    instructions.text(\'No speech was detected. Try again.\');  
  }
};
$(\'#start-record-btn\').on(\'click\', function(e) {
  if (noteContent.length) {
    noteContent += \' \';
  }
  recognition.start();
});


$(\'#pause-record-btn\').on(\'click\', function(e) {
  recognition.stop();
  instructions.text(\'Voice recognition paused.\');
});

// Sync the text inside the text area with the noteContent variable.
noteTextarea.on(\'input\', function() {
  noteContent = $(this).val();
});

var speech = new SpeechSynthesisUtterance();

window["readOutLoud"] = function(message) {
  // Set the text and voice attributes.
    speech.text = message;
    speech.volume = 1;
    speech.rate = 0.90;
    speech.pitch = 1;  
    window.speechSynthesis.speak(speech);
};
var lstVocab = {
"what is your name":  "My name is  ChuChi",
"bad":  "chal bhootni ke",
"good":  "thank you",
"how are you":  "Thank you, i am good",
"hi":  "Hi, How are you?",
"hello":  "Hello, My name is  ChuChi"
};
function replyBack2(line){
    let v1 = false;
    $.each(lstVocab,function(key,val){
            if(line.indexOf(key) > -1){
                readOutLoud(val);
                v1 = true;
            }
    });
    if(v1){
    }else if(line.indexOf("my name") > -1){
        let name = line.split("name") 
        readOutLoud("Hi " + name[1]);
    }else{
        readOutLoud("Not Understand");        
    }
}

');
        addHeaderJsFunction($this->name . "_reply_back", 'function replyBack(line){ ', '$.each(lstVocab,function(key,val){
            if(line.indexOf(key) > -1){
                readOutLoud(val);
            }
    });}');
        $this->setPreTag('<h3 class="no-browser-support" style="display: none;">Sorry, Your Browser Doesn\'t Support Talk. Try Google Chrome.</h3>');
        $this->setInnerHtml(' <div class="voicereco"><div class="input-single">
                    <textarea id="note-textarea" style="display:none;" placeholder="Create a new note by typing or using voice recognition." rows="6"></textarea>
                </div>         
                <button id="start-record-btn" title="Listen" class="btn btn-primary">Listen</button>
                <button id="pause-record-btn" title="Pause Listen" class="btn btn-primary">Pause</button>
                <p id="recording-instructions"></p></div>');
    }
}
