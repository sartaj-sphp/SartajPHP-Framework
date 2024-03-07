<?php

/**
 * Description of DateField
 *
 * @author SARTAJ
 */

namespace Sphp\comp\html {

    class DateField extends \Sphp\tools\Control {

        public $datemin = '';
        public $datemax = '';
        private $appendText = 'dd-mm-yy';
        private $image = "";
        private $nomonth = "";
        private $errmsg = '';
        private $formName = '';
        private $msgName = '';
        private $req = false;

        public function oninit() {
            \SphpJsM::addjQueryUI();
            if ($this->value != '') {
                $this->value = $this->dateToMySQLDate($this->value);
            }
            if ($this->getAttribute("msgname") != "") {
                $this->msgName = $this->getAttribute("msgname");
            }
            $this->unsetEndTag();
        }

        protected function genhelpPropList() {
            $this->addHelpPropFunList('setForm', 'Bind with Form JS Event', '', '$val');
            $this->addHelpPropFunList('setMsgName', 'Name Display in placeholder and Error', '', '$val');
            $this->addHelpPropFunList('setRequired', 'Can not submit Empty', '', '');
            $this->addHelpPropFunList('setDateMin', 'Set Minimum Date can Select, check jquery ui date', '', '$val');
            $this->addHelpPropFunList('setDateMax', 'Set Max Date can Select, check jquery ui date', '', '$val');
            $this->addHelpPropFunList('setAppendText', 'Set Append Text with Date', '', '$val');
            $this->addHelpPropFunList('setButtonImage', 'Button image path ', '', '$filepath');
            $this->addHelpPropFunList('setNumMonths', 'Max Months to Display', '', '$val');
        }

        public function setErrMsg($msg) {
            $this->errmsg .= '<strong class="alert-danger">' . $msg . '</strong>';
            if(\SphpBase::sphp_request()->isAJAX()){
                \SphpBase::JSServer()->addJSONJSBlock('$("#'. $this->name .'").after("<strong class=\"alert-danger\">' . $msg . '! </strong>");');
            }
            setErr($this->name, $msg);
        }

        public function setForm($val) {
            $this->formName = $val;
        }

        public function setMsgName($val) {
            $this->msgName = $val;
            $this->setAttribute('placeholder', $val);
        }

        public function setRequired() {
            if ($this->issubmit) {
                if (strlen($this->value) < 1) {
                    $this->setErrMsg($this->getAttribute("msgname") . ' ' . "Can not submit Empty");
                }
            }
            $this->req = true;
        }

        private function dateToMySQLDate($date) {
            $date1 = $this->createDate($this->appendText, $date, 'Y-m-d', 0, 0, 0);
            return $date1;
        }

        public function createDate($dformat, $beginDate, $outformat, $offsetd, $offsetm, $offsety) {
// find date separator
            $dsep = ' ';
            if (strpos($dformat, '/') > 0) {
                $dsep = '/';
            }
            if (strpos($dformat, '-') > 0) {
                $dsep = '-';
            }
            $date_parts2 = explode($dsep, $beginDate);
            $date_parts3 = explode($dsep, $dformat);
            if ($date_parts3[0] == 'mm' && $date_parts3[1] == 'dd') {
                $date_parts1[0] = $date_parts2[1];
                $date_parts1[1] = $date_parts2[0];
                $date_parts1[2] = $date_parts2[2];
            } else if ($date_parts3[0] == 'mm' && $date_parts3[1] == 'yy') {
                $date_parts1[0] = $date_parts2[2];
                $date_parts1[1] = $date_parts2[0];
                $date_parts1[2] = $date_parts2[1];
            } else if ($date_parts3[0] == 'yy' && $date_parts3[1] == 'dd') {
                $date_parts1[0] = $date_parts2[1];
                $date_parts1[1] = $date_parts2[2];
                $date_parts1[2] = $date_parts2[0];
            } else if ($date_parts3[0] == 'yy' && $date_parts3[1] == 'mm') {
                $date_parts1[0] = $date_parts2[2];
                $date_parts1[1] = $date_parts2[1];
                $date_parts1[2] = $date_parts2[0];
            } else if ($date_parts3[0] == 'dd' && $date_parts3[1] == 'yy') {
                $date_parts1[0] = $date_parts2[0];
                $date_parts1[1] = $date_parts2[2];
                $date_parts1[2] = $date_parts2[1];
            } else {
                $date_parts1 = $date_parts2;
            }

            $date1 = date($outformat, mktime(0, 0, 0, $date_parts1[1] + $offsetm, $date_parts1[0] + $offsetd, $date_parts1[2] + $offsety));
            return $date1;
        }

        public function mysqlDateToDate($df) {
            if ($df != '') {
                $dformat = $this->appendText;
                $dformat = str_replace('dd', 'd', $dformat);
                $dformat = str_replace('mm', 'm', $dformat);
                $dformat = str_replace('yy', 'Y', $dformat);

                $date1 = date($dformat, strtotime($df));
                return $date1;
            }
        }

        public function setDateMin($val) {
            $this->datemin = $val;
        }

        public function setDateMax($val) {
            $this->datemax = $val;
        }

        public function setAppendText($val) {
            $this->appendText = $val;
        }

        public function setButtonImage($val) {
            $this->image = $val;
        }

        public function setNumMonths($val) {
            $this->nomonth = $val;
        }

        public function onjsrender() {
            $sphp_settings = \SphpBase::sphp_settings();
//addFileLink("$jquerypath/themes/base/jquery.ui.all.css");
//addFileLink("$jquerypath/ui/jquery.ui.core.min.js");
//addFileLink("$jquerypath/ui/jquery.ui.widget.min.js");
//addFileLink("$jquerypath/ui/jquery.ui.datepicker.min.js");
            $str = '';
            if ($this->appendText != '') {
                $str .= ",appendText: '$this->appendText', dateFormat: '$this->appendText'";
            }
            if ($this->image == '') {
                $this->image = $sphp_settings->slib_res_path . "/comp/html/res/calendar.gif";
            }
            if ($this->image != '') {
                $str .= ",showOn: 'button',buttonImageOnly: true, buttonImage: '$this->image'";
            }
            if ($this->datemax != '') {
                $str .= ",maxDate: '$this->datemax'";
            }
            if ($this->datemin != '') {
                $str .= ",minDate: '$this->datemin'";
            }
            if ($this->nomonth != '') {
                $str .= ",numberOfMonths: $this->nomonth";
            }
            $this->setParameterA('onfocus', '$(\'#' . $this->name . '\').datepicker(\'show\');');
            addHeaderJSFunctionCode('ready', $this->name, "
$('#$this->name').datepicker({ changeMonth: true,changeYear: true $str});
");
            if ($this->formName != '') {
                if ($this->req) {
                    addHeaderJSFunctionCode("{$this->formName}_submit", "{$this->name}req", "
ctlReq['$this->name']= Array('$this->msgName','TextField');");
                }
            }
        }

        public function onrender() {
            if ($this->errmsg != "") {
                $this->setPostTag($this->errmsg);
            }
            if ($this->getAttribute('class') == '') {
                $this->class = "form-control";
            }
            if ($this->value != '') {
                $this->setAttribute('value', $this->mysqlDateToDate($this->value));
            }
            $this->setAttribute('type', 'text');
            $this->setAttribute('readonly', 'readonly');
        }

// javascript functions
        public function getJSValue() {
            return "document.getElementById('$this->name').value";
        }

        public function setJSValue($exp) {
            $jsOut = "document.getElementById('$this->name').value = $exp;";
        }

    }

}
