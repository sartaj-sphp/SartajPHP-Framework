try {
  var SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
  var recognition = new SpeechRecognition();
}
catch(e) {
  console.error(e);
  $('.no-browser-support').show();
  $('.voicereco').hide();
}


var noteTextarea = $('#note-textarea');
var instructions = $('#recording-instructions');

var noteContent = '';

// If false, the recording will stop after a few seconds of silence.
// When true, the silence period is longer (about 15 seconds),
// allowing us to keep recording even when the user pauses. 
recognition.continuous = true;

// This block is called every time the Speech APi captures a line. 
recognition.onresult = function(event) {

  // event is a SpeechRecognitionEvent object.
  // It holds all the lines we have captured so far. 
  // We only need the current one.
  var current = event.resultIndex;

  // Get a transcript of what was said.
  var transcript = event.results[current][0].transcript;

  // Add the current transcript to the contents of our Note.
  // There is a weird bug on mobile, where everything is repeated twice.
  // There is no official solution so far so we have to handle an edge case.
  var mobileRepeatBug = (current == 1 && transcript == event.results[0][0].transcript);
  replyBack(transcript.trim().toLowerCase());
  if(!mobileRepeatBug) {
    noteContent += transcript;
    noteTextarea.val(noteContent);
  }
};

recognition.onstart = function() { 
    readOutLoud("I am ready to listen you");
  instructions.text('Activated. Try speaking into the microphone.');
}

recognition.onspeechend = function() {
    readOutLoud("Bye Bye");
  instructions.text('You were quiet for a while turned itself off.');
}

recognition.onerror = function(event) {
  if(event.error == 'no-speech') {
    instructions.text('No speech was detected. Try again.');  
  };
}



/*-----------------------------
      App buttons and input 
------------------------------*/

$('#start-record-btn').on('click', function(e) {
  if (noteContent.length) {
    noteContent += ' ';
  }
  recognition.start();
});


$('#pause-record-btn').on('click', function(e) {
  recognition.stop();
  instructions.text('Voice recognition paused.');
});

// Sync the text inside the text area with the noteContent variable.
noteTextarea.on('input', function() {
  noteContent = $(this).val();
})



/*-----------------------------
      Speech Synthesis 
------------------------------*/
var speech = new SpeechSynthesisUtterance();

function readOutLoud(message) {

  // Set the text and voice attributes.
	speech.text = message;
	speech.volume = 1;
	speech.rate = 0.90;
	speech.pitch = 1;
  
	window.speechSynthesis.speak(speech);
}
var lstVocab = {
"what is your name":  "My name is  ChuChi",
"bad":  "chal bhootni ke",
"good":  "thank you",
"how are you":  "Thank you, i am good",
"hi":  "Hi, How are you?",
"hello":  "Hello, My name is  ChuChi",
"":"",
"":"",
"":""
};
function replyBack(line){
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
