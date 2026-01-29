<?php
/**
 * Description of Add Rotator
 *
 * @author SARTAJ
 */


class DL extends Sphp\tools\Component{
protected function oncreate($element){
$this->setHTMLName("");
}

protected function onjsrender(){
if($this->parameterA['class'] == ''){
    addHeaderCSS('dl', '
.dl
{
	float: left;
	width: 170px;
	font-size: 1.3em;
	margin: 0;
	padding: 0;
	padding-right: 10px;
}
.dl dt 
{
	margin: 0;
	padding: 0;
	font: normal 1.1em "Trebuchet MS", "Helvetica", "Arial",  "Verdana", "sans-serif";
	color: #e87b10;
	margin-top: 1.5em;
	margin-bottom: 0;
	padding-left: 8px;
	padding-bottom:5px;
	line-height: 1.2em;
	border-bottom: 1px solid #F4F4F4;
}
.dl dd 
{
	margin: 0;
	padding: 0;
}
.dl dd a
 {
	border-bottom: 1px solid #F4F4F4;
	display:block;
	padding: 4px 3px 4px 8px;
	font-size: 90%;
	text-decoration: none;
	color: #555 ;
	margin:2px 0;
	height:13px;
}

.dl dd a:hover,
.dl dd a:focus {
	background: #f3f3f3;
	color:#000;
	-moz-border-radius: 5px; -webkit-border-radius: 5px;
}
 .dl dd a.selected {
	background: #555;
	color:#ffffff;
	-moz-border-radius: 5px; -webkit-border-radius: 5px;
}
');
$this->parameterA['class'] = 'dl';
}

}


}
?>