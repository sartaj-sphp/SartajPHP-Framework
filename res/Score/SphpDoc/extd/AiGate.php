<?php
include_once(\SphpBase::sphp_settings()->getLib_path() . '/lib/CURL.php');
class AiGate extends \Sphp\tools\NativeGate {
protected $host = "127.0.0.1";
protected $port = 11434;
protected $appUrl = "";
protected $curl = null;
protected $skillFile = "";
public  function onready() {}
/**
* Set skill file path (YAML file with skills, rules, commands)
* This file is loaded and passed to AI model for context
*/
protected function setSkillFile($filePath) {}
/**
* Load skill content from YAML file
*/
protected function getSkillContent() {}
/**
* Get response format instruction
* @param string $format 'json', 'yaml', 'plain', 'code'
*/
protected function getFormatInstruction($format = 'plain', $schema = null) {}
/**
* Build Prompt add more things in prompt like skill file, output format
* @param string $prompt User Prompt for AI Model
* @param string $format Response format ('json', 'yaml', 'code', 'plain')
* @param string $schema JSON schema for validation (optional) {"answer": "boolean", "explanation": "string", "calculation": "string"}
* @return string
*/
protected function buildPrompt($prompt, $format = 'plain', $schema = null){}
/**
* Send prompt to AI model with format instruction.
*  Data for Ollama:-  $data = [
'model' => "model",
'prompt' => $this->buildPrompt("Is All Persons are male in list: $list","json",{"answer": "boolean"}),
'stream' => false,
'options' => [
'temperature' => 0.7,
'num_predict' => 2048
]
];
* @param string $data The AI Server post data in API format as JSON Array Object 
* @param string $evt Event name for response
* @param string $evtp Event parameter
*/
protected function sendToAi($data,$evt,$evtp="") {}
/**
* It is called from event loop of parent class
* Override wait event handler of NativeGate
*/
public function onwait() {}
}
