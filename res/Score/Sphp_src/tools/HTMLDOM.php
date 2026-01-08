<?php
namespace Sphp\tools{

class HTMLDOM {
    public $root = null;
    public $nodes = array();
    public $callback = null;
    public $lowercase = false;
    public $pos;
    protected $doc;
    protected $chara;
    protected $size;
    public $cursor;
    protected $parent;
    protected $noise = array();
    protected $token_blank = "";
    protected $token_slash = "";
    protected $token_equal = ' =/>';
    protected $token_attr = ' >';
    // use isset instead of in_array, performance boost about 30%...
    protected $self_closing_tags = array('img'=>1, 'br'=>1, 'input'=>1, 'meta'=>1, 'link'=>1, 'hr'=>1, 'base'=>1, 'embed'=>1, 'spacer'=>1);
    protected $block_tags = array('root'=>1, 'body'=>1, 'form'=>1, 'div'=>1, 'span'=>1, 'table'=>1);
    // start closing tags array
    private $atr = array('tr'=>1, 'td'=>1, 'th'=>1);
    private $ath = array('th'=>1);
    private $atd = array('td'=>1);
    private $ali = array('li'=>1);
    private $adt = array('dt'=>1, 'dd'=>1);
    private $aadd = array('dd'=>1, 'dt'=>1);
    private $adl = array('dd'=>1, 'dt'=>1);
    private $ap = array('p'=>1);
    private $anobr = array('nobr'=>1);
    
    
    protected $optional_closing_tags = array();
    const HDOM_TYPE_ELEMENT = 1;
    const HDOM_TYPE_COMMENT = 2;
    const HDOM_TYPE_TEXT = 3;
    const HDOM_TYPE_ENDTAG = 4;
    const HDOM_TYPE_ROOT = 5;
    const HDOM_TYPE_UNKNOWN = 6;
    const HDOM_QUOTE_DOUBLE = 0;
    const HDOM_QUOTE_SINGLE = 1;
    const HDOM_QUOTE_NO = 3;
    const HDOM_INFO_BEGIN = 0;
    const HDOM_INFO_END = 1;
    const HDOM_INFO_QUOTE = 2;
    const HDOM_INFO_SPACE = 3;
    const HDOM_INFO_TEXT = 4;
    const HDOM_INFO_INNER = 5;
    const HDOM_INFO_OUTER = 6;
    const HDOM_INFO_ENDSPACE = 7;

    public function __construct($str=null) {
        $this->optional_closing_tags = array(
        'tr' =>$this->atr,
        'th'=>$this->ath,
        'td'=>$this->atd,
        'li'=>$this->ali,
        'dt'=>$this->adt,
        'dd'=>$this->aadd,
        'dl'=>$this->adl,
        'p'=>$this->ap,
        'nobr'=>$this->anobr,
    );
        $this->token_blank = " " . TABCHAR . RLINE . NEWLINE ;
        $this->token_slash = " />" . RLINE . NEWLINE . TABCHAR ;
        if ($str) {
            if (preg_match("/^http:\/\//i",$str) || is_file($str)) 
                $this->load_file($str); 
            else
                $this->load($str);
        }
    }

    public function __destruct() {
        // not work in extension
        $this->clear();
    }
    

    // load html from string
    public function load($str, $lowercase=true) {
        // prepare
        $this->prepare($str, $lowercase);
        if(!\SphpBase::sphp_settings()->blnEditMode){
        // strip out comments
        $this->remove_noise("'<!--(.*?)-->'is");
        // strip out cdata
        $this->remove_noise("'<!\[CDATA\[(.*?)\]\]>'is", true);
        // strip out <style> tags
        $this->remove_noise("'<\s*style[^>]*[^/]>(.*?)<\s*/\s*style\s*>'is");
        $this->remove_noise("'<\s*style\s*>(.*?)<\s*/\s*style\s*>'is");
        // strip out <script> tags
        $this->remove_noise("'<\s*script[^>]*[^/]>(.*?)<\s*/\s*script\s*>'is");
        $this->remove_noise("'<\s*script\s*>(.*?)<\s*/\s*script\s*>'is");
        // strip out preformatted tags
        $this->remove_noise("'<\s*(?:code)[^>]*>(.*?)<\s*/\s*(?:code)\s*>'is");
        // strip out server side scripts
        $this->remove_noise("'(<\?)(.*?)(\?>)'s", true); 
        // strip smarty scripts
        $this->remove_noise("'(\{\w)(.*?)(\})'s", true);
        }
        //file_put_contents("D:/test2.html",$this->doc);
        // parsing
        $line_count = 0;
        while ($this->parse()){
            $line_count += 1;
        }
        // end
        $this->root->setA(self::HDOM_INFO_END,$this->cursor);
    }

    // load html from file
    public function load_file($filepath) {
        $this->load(file_get_contents($filepath), true);
    }
    public function load_file_str($filepath) {
        return (file_get_contents($filepath));
    }

    // set callback public function
    public function set_callback($function_name,$obj) {
        $this->callback = array($function_name,$obj);
    }

    // remove callback public function
    public function remove_callback() {
        $this->callback = null;
    }

    // save dom as string
    public function save($filepath='') {
        $ret = $this->root->innertext();
        if ($filepath!==''){
            file_put_contents($filepath, $ret);
        }
        return $ret;
    }

    // find dom node by css selector
    public function find($selector, $idx=null) {
        return $this->root->find($selector, $idx);
    }

    // clean up memory due to php5 circular references memory leak...
    public function clear() {
        foreach($this->nodes as $n) {
            $n->clear(); 
            $n = null;            
        }
        if (isset($this->parent)) {
            $this->parent->clear();
            unset($this->parent);
            
        }
        if (isset($this->root)) {
            $this->root->clear();
            unset($this->root);
            
        }
        unset($this->doc);
        unset($this->noise);
    }
    
    public function getDoc() {
        return $this->doc;
    }
    public function dump($show_attr=true) {
        $this->root->dump($show_attr);
    }

    public function countLines($pos1) {
        //return substr($this->doc,0,$pos1);
        return substr_count($this->doc, "\n",0,$pos1);
        //return json_encode($this->nodes);
    }
    // prepare HTML data and init everything
    protected function prepare($str, $strlowercase=true) {
        //$this->clear();
        $this->doc = $str;
        $this->pos = 0;
        $this->cursor = 1;
        $this->noise = array();
        $this->nodes = array();
        $this->lowercase = $strlowercase;
        $this->root = new HTMLDOMNode($this);
        $this->root->setTag('root');
        $this->root->setA(self::HDOM_INFO_BEGIN, -1);
        $this->root->setNodetype(self::HDOM_TYPE_ROOT);
        $this->parent = $this->root;
        // set the length of content
        $this->size = strlen($str);
        if ($this->size>0){
            $this->chara = $this->doc[0];
        }
    }

    // parse html content
    protected function parse() {
        if (($s = $this->copy_until_char('<'))===''){
            return $this->read_tag();
        }
        // text
        $node = new HTMLDOMNode($this);
        ++$this->cursor;
        $node->setA(self::HDOM_INFO_TEXT,$s);
        $this->link_nodes($node, false);
        return true;
    }

    // read tag info
    protected function read_tag() {
        try{
        if ($this->chara!=='<') {
            $this->root->setA(self::HDOM_INFO_END, $this->cursor);
            return false;
        }
        $begin_tag_pos = $this->pos;
        $this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null; // next

        // end tag
        if ($this->chara==='/') {
            $this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null; // next
            $this->skip($this->token_blank);
            $tag = $this->copy_until_char('>');

            // skip attributes in end tag
            if (($pos = strpos($tag, ' '))!==false)
                $tag = substr($tag, 0, $pos);

            $parent_lower = strtolower($this->parent->getTag());
            $tag_lower = strtolower($tag);

            if ($parent_lower!==$tag_lower) {
                if (isset($this->optional_closing_tags[$parent_lower]) && isset($this->block_tags[$tag_lower])) {
                    $this->parent->setA(self::HDOM_INFO_END, 0);
                    $org_parent = $this->parent;

                    while (($this->parent->parent) && strtolower($this->parent->getTag())!==$tag_lower)
                        $this->parent = $this->parent->parent;

                    if (strtolower($this->parent->getTag())!==$tag_lower) {
                        $this->parent = $org_parent; // restore origonal parent
                        if ($this->parent->parent) $this->parent = $this->parent->parent;
                        $this->parent->setA(self::HDOM_INFO_END, $this->cursor);
                        return $this->as_text_node($tag);
                    }
                }
                else if (($this->parent->parent) && isset($this->block_tags[$tag_lower])) {
                    $this->parent->setA(self::HDOM_INFO_END, 0);
                    $org_parent = $this->parent;

                    while (($this->parent->parent) && strtolower($this->parent->getTag())!==$tag_lower)
                        $this->parent = $this->parent->parent;

                    if (strtolower($this->parent->getTag())!==$tag_lower) {
                        $this->parent = $org_parent; // restore origonal parent
                        $this->parent->setA(self::HDOM_INFO_END, $this->cursor);
                        return $this->as_text_node($tag);
                    }
                }
                else if (($this->parent->parent) && strtolower($this->parent->parent->tag)===$tag_lower) {
                    $this->parent->setA(self::HDOM_INFO_END, 0);
                    $this->parent = $this->parent->parent;
                }
                else
                    return $this->as_text_node($tag);
            }

            $this->parent->setA(self::HDOM_INFO_END,$this->cursor);
            if ($this->parent->parent) $this->parent = $this->parent->parent;

            $this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null; // next
            return true;
        }

        $node = new HTMLDOMNode($this);
        $node->setA(self::HDOM_INFO_BEGIN, $this->cursor);
        ++$this->cursor;
        $tag = $this->copy_until($this->token_slash);

        // doctype, cdata & comments...
        if (isset($tag[0]) && $tag[0]==='!') {
            $node->setA(self::HDOM_INFO_TEXT, '<' . $tag . $this->copy_until_char('>'));

            if (isset($tag[2]) && $tag[1]==='-' && $tag[2]==='-') {
                $node->nodetype = self::HDOM_TYPE_COMMENT;
                $node->tag = 'comment';
            } else {
                $node->nodetype = self::HDOM_TYPE_UNKNOWN;
                $node->tag = 'unknown';
            }

            if ($this->chara==='>') $node->setAppendA(self::HDOM_INFO_TEXT,'>');
            $this->link_nodes($node, true);
            $this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null; // next
            return true;
        }

        // text
        if ($pos=strpos($tag, '<')!==false) {
            $tag = '<' . substr($tag, 0, -1);
            $node->setA(self::HDOM_INFO_TEXT, $tag);
            $this->link_nodes($node, false);
            $this->pos--;
            $pos1 = $this->pos;
            $this->chara = $this->doc[$pos1]; // prev
            return true;
        }

        if (!preg_match("/^[\w\-:]+$/", $tag)) {
            $node->setA(self::HDOM_INFO_TEXT, '<' . $tag . $this->copy_until('<>'));
            if ($this->chara==='<') {
                $this->link_nodes($node, false);
                return true;
            }

            if ($this->chara==='>') $node->setAppendA(self::HDOM_INFO_TEXT,'>');
            $this->link_nodes($node, false);
            $this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null; // next
            return true;
        }

        // begin tag
        $node->nodetype = self::HDOM_TYPE_ELEMENT;
        $tag_lower = strtolower($tag);
        $node->tag = ($this->lowercase) ? $tag_lower : $tag;

        // handle optional closing tags
        if (isset($this->optional_closing_tags[$tag_lower]) ) {
            $parenttag = strtolower($this->parent->getTag());
            while (isset($this->optional_closing_tags[$tag_lower][$parenttag])) {
                $this->parent->setA(self::HDOM_INFO_END,0);
                $this->parent = $this->parent->parent;
            }
            $node->parent = $this->parent;
        }

        $guard = 0; // prevent infinity loop
        $space = array($this->copy_skip($this->token_blank), '', '');

        // attributes
        do {
            if ($this->chara!==null && $space[0]==='') break;
            $name = $this->copy_until($this->token_equal);
            if($guard===$this->pos) {
                $this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null; // next
                continue;
            }
            $guard = $this->pos;

            // handle endless '<'
            if($this->pos>=$this->size-1 && $this->chara!=='>') {
                $node->nodetype = self::HDOM_TYPE_TEXT;
                $node->setA(self::HDOM_INFO_END, 0);
                $node->setA(self::HDOM_INFO_TEXT, '<' . $tag . $space[0] . $name);
                $node->tag = 'text';
                $this->link_nodes($node, false);
                return true;
            }

            // handle mismatch '<'
            if($this->doc[$this->pos-1]=='<') {
                $node->nodetype = self::HDOM_TYPE_TEXT;
                $node->tag = 'text';
                $node->attr = array();
                $node->setA(self::HDOM_INFO_END, 0);
                $node->setA(self::HDOM_INFO_TEXT, substr($this->doc, $begin_tag_pos, $this->pos-$begin_tag_pos-1));
                $this->pos -= 2;
                $this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null; // next
                $this->link_nodes($node, false);
                return true;
            }

            if ($name!=='/' && $name!=='') {
                $space[1] = $this->copy_skip($this->token_blank);
                $name = $this->restore_noise($name);
                if ($this->lowercase) $name = strtolower($name);
                if ($this->chara==='=') {
                    $this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null; // next
                    $this->parse_attr($node, $name, $space);
                }
                else {
                    //no value attr: nowrap, checked selected...
                    $node->setAA(self::HDOM_INFO_QUOTE, self::HDOM_QUOTE_NO);
                    $node->attr[$name] = true;
                    if ($this->chara!='>'){
                        $this->pos--;
                        $pos1 = $this->pos;
                        $this->chara = $this->doc[$pos1]; // prev
                    }
                }
                $node->setAA(self::HDOM_INFO_SPACE, $space);
                $space = array($this->copy_skip($this->token_blank), '', '');
            }
            else{
                break;
            }
        } while($this->chara!=='>' && $this->chara!=='/');

        $this->link_nodes($node, true);
        $node->setA(self::HDOM_INFO_ENDSPACE, $space[0]);

        // check self closing
        if ($this->copy_until_char_escape('>')==='/') {
            $node->setAppendA(self::HDOM_INFO_ENDSPACE, '/');
            $node->setA(self::HDOM_INFO_END, 0);
        }
        else {
            // reset parent
            $nodelc = strtolower($node->tag);
            if (!isset($this->self_closing_tags[$nodelc])) $this->parent = $node;
        }
        $this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null; // next
        return true;
        }catch(\Sphp\core\Exception $e){
            $e1 = new \Sphp\core\Exception("HTML Parser Error:- Tag: ". $node->tag . " CharPos: " . $this->pos ." " . $e->getMessage());
            throw $e1;
        }
    }

    // parse attributes
    protected function parse_attr($node, $name, $space) {
        $space[2] = $this->copy_skip($this->token_blank);
        switch($this->chara) {
            case '"':
                $node->setAA(self::HDOM_INFO_QUOTE, self::HDOM_QUOTE_DOUBLE);
                $this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null; // next
                $node->attr[$name] = $this->restore_noise($this->copy_until_char_escape('"'));
                $this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null; // next
                break;
            case '\'':
                $node->setAA(self::HDOM_INFO_QUOTE, self::HDOM_QUOTE_SINGLE);
                $this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null; // next
                $node->attr[$name] = $this->restore_noise($this->copy_until_char_escape('\''));
                $this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null; // next
                break;
            default:
                $node->setAA(self::HDOM_INFO_QUOTE, self::HDOM_QUOTE_NO);
                $node->attr[$name] = $this->restore_noise($this->copy_until($this->token_attr));
        }
    }

    // link node's parent
    protected function link_nodes($node, $is_child) {
        $node->parent = $this->parent;
        $this->parent->addNode($node);
        if ($is_child)
            $this->parent->addChild($node);
    }

    // as a text node
    protected function as_text_node($tag) {
        $node = new HTMLDOMNode($this);
        ++$this->cursor;
        $node->setA(self::HDOM_INFO_TEXT, '</' . $tag . '>');
        $this->link_nodes($node, false);
        $this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null; // next
        return true;
    }

    protected function skip($chars) {
        $this->pos += strspn($this->doc, $chars, $this->pos);
        $this->chara = ($this->pos<$this->size) ? $this->doc[$this->pos] : null; // next
    }

    protected function copy_skip($chars) {
        $pos = $this->pos;
        $len = strspn($this->doc, $chars, $pos);
        $this->pos += $len;
        $this->chara = ($this->pos<$this->size) ? $this->doc[$this->pos] : null; // next
        if ($len===0) return '';
        return substr($this->doc, $pos, $len);
    }

    protected function copy_until($chars) {
        $pos = $this->pos;
        $len = strcspn($this->doc, $chars, $pos);
        $this->pos += $len;
        $this->chara = ($this->pos<$this->size) ? $this->doc[$this->pos] : null; // next
        return substr($this->doc, $pos, $len);
    }

    protected function copy_until_char($chara) {
        if ($this->chara===null) return '';

        if (($pos = strpos($this->doc, $chara, $this->pos))===false) {
            $ret = substr($this->doc, $this->pos, $this->size-$this->pos);
            $this->chara = null;
            $this->pos = $this->size;
            return $ret;
        }

        if ($pos===$this->pos) return '';
        $pos_old = $this->pos;
        $this->chara = $this->doc[$pos];
        $this->pos = $pos;
        return substr($this->doc, $pos_old, $pos-$pos_old);
    }

    protected function copy_until_char_escape($chara) {
        if ($this->chara===null) return '';

        $start = $this->pos;
        while(1) {
            if (($pos = strpos($this->doc, $chara, $start))===false) {
                $ret = substr($this->doc, $this->pos, $this->size-$this->pos);
                $this->chara = null;
                $this->pos = $this->size;
                return $ret;
            }

            if ($pos===$this->pos) return '';

            if ($this->doc[$pos-1]==='\\') {
                $start = $pos+1;
                continue;
            }

            $pos_old = $this->pos;
            $this->chara = $this->doc[$pos];
            $this->pos = $pos;
            return substr($this->doc, $pos_old, $pos-$pos_old);
        }
    }

    // remove noise from html content
    protected function remove_noise($pattern, $remove_tag=false) {
        $matches = array();
        $count = preg_match_all($pattern, $this->doc, $matches, PREG_SET_ORDER|PREG_OFFSET_CAPTURE);

        for ($i=$count-1; $i>-1; --$i) {
            $key = '___noise___'. sprintf('% 3d', count($this->noise)+100);
            $idx = ($remove_tag) ? 0 : 1;
            $this->noise[$key] = $matches[$i][$idx][0];
            $this->doc = substr_replace($this->doc, $key, $matches[$i][$idx][1], strlen($matches[$i][$idx][0]));
        }

        // reset the length of content
        $this->size = strlen($this->doc);
        if ($this->size>0) $this->chara = $this->doc[0];
    }

    // restore noise to html content
    public function restore_noise($text) {
        while(($pos=strpos($text, '___noise___'))!==false) {
            $key = '___noise___'.$text[$pos+11].$text[$pos+12].$text[$pos+13];
            if (isset($this->noise[$key]))
                $text = substr($text, 0, $pos).$this->noise[$key].substr($text, $pos+14);
        }
        return $text;
    }

    public function __toString() {
        return $this->root->innertext();
    }

    public function __get($name) {
        switch($name) {
            case 'outertext': return $this->root->innertext();
            case 'innertext': return $this->root->innertext();
            case 'plaintext': return $this->root->text();
        }
    }

    // camel naming conventions
    public function childNodes($idx=-1) {return $this->root->childNodes($idx);}
    public function firstChild() {return $this->root->first_child();}
    public function lastChild() {return $this->root->last_child();}
    public function getElementById($id) {return $this->find("#$id", 0);}
    public function getElementsById($id, $idx=null) {return $this->find("#$id", $idx);}
    public function getElementByTagName($name) {return $this->find($name, 0);}
    public function getElementsByTagName($name, $idx=-1) {return $this->find($name, $idx);}
    public function loadFile() {$args = func_get_args();$this->load(call_user_func_array('file_get_contents', $args), true);}

}
}
