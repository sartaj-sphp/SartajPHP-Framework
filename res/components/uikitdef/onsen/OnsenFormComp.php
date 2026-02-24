<?php

class OnsenFormComp extends \Sphp\tools\Component {

    private $formName = '';

    public function fi_setForm($val) {
        $this->formName = $val;
    }

    protected function onrender(){

        $hiddenId = $this->name . "_hidden";

        // Add hidden real input for serializeAssoc
        $this->addPostTag(
            '<input type="hidden" 
                    id="'.$hiddenId.'" 
                    name="'.$this->name.'" />'
        );

        // Sync ons-input value into hidden input before submit
        addHeaderJSFunctionCode(
            $this->formName . "_submit",
            $this->name,
            '
            var realVal = $("#'.$this->name.'").find("input").val();
            $("#'.$hiddenId.'").val(realVal);
            '
        );
    }
}