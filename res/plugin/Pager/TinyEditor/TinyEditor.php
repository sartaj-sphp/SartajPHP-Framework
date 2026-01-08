<?php
/**
 * Description of TinyEditor
 *
 * @author SARTAJ
 */
include_once(SphpBase::sphp_settings()->slib_path . "/comp/html/TextArea.php");
include_once(SphpBase::sphp_settings()->lib_path . "/lib/DIR.php");


class TinyEditor extends \Sphp\comp\html\TextArea{
private $templatelist = "";
private $imglist = "";
private $medialist = "";
/** new DIR() */
private $dir = null;
private $contentcss = "";
private $value2 = "";

    protected function oninit() {
        global $respath;
        $this->tagName = "textarea";
        if ($this->issubmit) {
            //$this->value = htmlentities($this->value, ENT_COMPAT, "UTF-8");
            $this->value = str_replace(["#{","}#","|"], ["# {","} #","&#124;"], $this->value);
        }
        if($this->getAttribute("msgname") != ""){
            $this->msgName = $this->getAttribute("msgname");
        }        
        $this->dir = new DIR();
        //$this->contentcss = "{$respath}/styles/framework.css";
        $this->contentcss = "{$this->myrespath}/css/content.css";
        $this->templatelist = "{$this->myrespath}/templates/templates/";
        $this->imglist = "{$this->mypath}/templates/imgs/";
        $this->medialist = "{$this->mypath}/templates/media/";
        if(SphpBase::page()->isevent){
            //$this->handleEvents();    
        }
    }

    //create temp file
public function processSphpComp(){
        $htmlparser = new \Sphp\tools\HTMLParser();
        $str = html_entity_decode($this->convertValue($this->value), ENT_COMPAT, "UTF-8");
        $str2 = $htmlparser->parseHTMLTag($str,"parseSphpComp",$this);
        return $str2;
}
public function parseSphpComp($element){
    //SphpBase::debug()->print_r($element->attr);
    if($element->tag != "text"){
        // covert tag like form which make problem in tiny but restore for temp file
        if(isset($element->attr["runtag"])){
            $element->tag = $element->attr["runtag"];
            unset($element->attr["runtag"]);
        }
                
        if(isset($element->attr["runat"])){
            if(isset($element->attr["path"])){
                $element->attr["path"] = str_replace("myplugpath/",SphpBase::sphp_settings()->php_path . "/plugin/Pager/comp/",$element->attr["path"]);
            }
            if(isset($element->attr["data-sphp"])){
                //SphpBase::debug()->println($element->attr["data-sphp"]);
                $ar1 = json_decode(urldecode($element->attr["data-sphp"]),true);
                foreach($ar1 as $key=>$val){
                    $element->attr[" " .$key] = $val[1];
                }
                unset($element->attr["data-sphp"]);

            }
        }
    }
}
    
public function fu_setContentCSS($val){
    $this->contentcss = $val;
}
public function fu_setImgListPath($val){
    $this->imglist = $val;
}
public function fu_setTemplatelateListPath($val){
    $this->templatelist = $val;
}
public function fu_setMediaListPath($val){
    $this->medialist = $val;
}
protected function onprejsrender(){ 
    global $basepath; 
    SphpBase::JSServer()->getAJAX();
    addFileLink($this->myrespath . '/vendor/tinymce/tinymce/tinymce.min.js');
    addFileLink($this->myrespath . '/js/property-editors.js');
    //addFileLink($this->myrespath . '/css/content.css');
    /*
   extended_valid_elements : "img[runat|path|pathres|id|name|src],div[runat|path|pathres|id],input[runat|path|pathres|id|name],textarea[runat|path|pathres|id|name],select[runat|path|pathres|id|name]",
        invalid_elements : "font",
        remove_linebreaks : false,
        inline_styles : false,
        convert_fonts_to_spans : true,
			script_url : "'.$this->myrespath . '/tiny_mce.js",

   extended_valid_elements : "img[runat|path|pathres|id|name|src|alt|title|class],div[runat|path|pathres|id|class],input[runat|path|pathres|id|name|class],textarea[runat|path|pathres|id|name|class],select[runat|path|pathres|id|name|class]",
     */
    // Function to get all CSS links from the document
    addHeaderJSCode($this->name . 'f', ' 
        function getAllCSSLinks() {
            const links = [];
            // Get all link elements with rel="stylesheet"
            document.querySelectorAll(\'link[rel="stylesheet"]\').forEach(link => {
                if (link.href) {
                    links.push(link.href);
                }
            });
            return links;
        } const cssLinks = getAllCSSLinks();
');
addHeaderJSFunctionCode('ready','tinyeditor'.$this->name,'
		tinymce.init({
                selector: "textarea#'. $this->name .'",
			theme : "silver",
			script_url : "'.$this->myrespath . '/vendor/tinymce/tinymce/tinymce.js",
			document_script_url : "'.$this->myrespath . '/vendor/tinymce/tinymce/",
                            content_css: cssLinks,
                        relative_urls : false,
                        remove_script_host : false,
                        newline_behavior: "linebreak",
                        document_base_url: "'.$basepath.'", '. "
  external_plugins: {
    bootstrapblocks: '". SphpBase::sphp_settings()->getBase_path() ."/{$this->myrespath}/splugins/sphpinput/plgbootstrap.js',
    smartpropertyeditor: '". SphpBase::sphp_settings()->getBase_path() ."/{$this->myrespath}/splugins/sphpinput/plgpropertyedt.js',
    plgpreview: '". SphpBase::sphp_settings()->getBase_path() ."/{$this->myrespath}/splugins/sphpinput/plgpreview.js',
    plgimg: '". SphpBase::sphp_settings()->getBase_path() ."/{$this->myrespath}/splugins/sphpinput/plgimg.js',        
    customattributes: '". SphpBase::sphp_settings()->getBase_path() ."/{$this->myrespath}/splugins/sphpinput/customattributes.js',
    sphppropertyeditor: '". SphpBase::sphp_settings()->getBase_path() ."/{$this->myrespath}/splugins/sphpinput/plgpropertyedtsphp.js',
  },
                        menu: {
    file: { title: 'File', items: 'save | newdocument restoredraft | preview | export print | deleteallconversations' },
    edit: { title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall | searchreplace' },
    view: { title: 'View', items: 'code | visualaid visualchars visualblocks | spellchecker | preview fullscreen | showcomments' },
    insert: { title: 'Insert', items: 'imageeditor link media addcomment pageembed template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor tableofcontents | insertdatetime' },
    format: { title: 'Format', items: 'bold italic underline strikethrough superscript subscript codeformat | styles blocks fontfamily fontsize align lineheight | forecolor backcolor | language | removeformat' },
    tools: { title: 'Tools', items: 'spellchecker spellcheckerlanguage | check code wordcount' },
    table: { title: 'Table', items: 'inserttable | cell row column | advtablesort | tableprops deletetable' },
    help: { title: 'Help', items: 'help'}
  }, 
  plugins: [
      'advlist','anchor', 'autolink', 'charmap', 'code', 'codesample','emoticons','fullscreen','help','importcss',
      'link','lists','media','nonbreaking','pagebreak','quickbars','save','searchreplace','table','template','visualblocks',
      'visualchars','wordcount'
    ],
    toolbar: 'save | undo redo | blocks | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
      'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
      'forecolor backcolor emoticons | help',
  ". '
 contextmenu: "smartpropertyeditor sphppropertyeditor",
    theme_advanced_resizing : true,
    template_external_list_url : "'. getEventURL($this->name.'_templatelist') .'",
    external_link_list_url : "'.getEventURL($this->name.'_linklist') .'",
    external_image_list_url : "'.getEventURL($this->name.'_imglist') .'",
    media_external_list_url : "'.getEventURL($this->name.'_medialist') .'"
        
});

');

}

private function convertValue($v) {
    if($this->value2 == ""){
        $v = str_replace(["[!","!]"], ["<",">"], $v);
        $v = html_entity_decode($v, ENT_COMPAT, "UTF-8");
        //$v = str_replace(["<script","</script","<?php",">"], ["<div","</div","<div>","</div>"], $v);
        $v = str_replace(["<script","</script","#{","}#"], ["<script2","</script2","# {","} #"], $v);
        $this->value2 = $this->parseHTML($v);
        //$this->value2 = $v;
        //echo $this->value2;
    }
    return $this->value2;
}

// call by parseHTML function
protected function onparse($event,$element) {
    if($event == "start" && $element->tag == "code"){
    //if($event == "start" && $element->tag == "pre" && $element->hasAttribute("class")){
      //  if(strpos($element->getAttribute("class"),"language-") !== false){
            //$element->tag = "div";
        $v = $element->innertext;
        $v = htmlentities(htmlspecialchars($v));
        //$v = str_replace(["#{","}#"], ["#&nbsp;{","}&nbsp;#"], $v);
        //echo $v;
        $element->setInnerHTML($v);
        //}
        
    }
        //echo  $element->tag . ' ';
}
protected function onrender() {
    $this->value = $this->convertValue($this->value);
    if($this->errmsg!=""){
        $this->setPostTag($this->errmsg);
    }
    if ($this->getAttribute('class') == '') {
        $this->class = "form-control";
    }

    if ($this->value != '') {
        $this->setInnerHTML($this->value);
    }

    $this->setAttributeDefault('rows', '150');
    $this->setAttributeDefault('cols', '20');
    
}

}
