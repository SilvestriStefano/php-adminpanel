<?php
Class Form{
    private $html='';
    private $fieldset_bool=false;

    public function __construct($method='', $action='', $id='')
    {   
        $form_id = !empty($id) ? "id='$id'" : '';
        $form_action = !empty($action) ? "action='$action'" : '';
        $form_method = !empty($method) ? "method='$method'" : '';
        $formStart = "<form $form_id $form_action $form_method>";
        $this->html.=$formStart;
    }
    public function fieldset($bool, $legend=''){
        if($bool){
            $this->fieldset_bool = true;
            $this->html.="<fieldset>";
            if($legend!=''){
                $legend = "<legend>$legend</legend>";
                $this->html.=$legend;
            }
        }
    }
    
    public function createInput($arr)
    {   
        $placeholder = isset($arr['placeholder']) ? "placeholder='".$arr['placeholder']."'" : '';
        $input_id = isset($arr['id']) ? "id='".$arr['id']."'" : '';
        $name = isset($arr['name']) ? "name='".$arr['name']."'" : '';
        $value = isset($arr['value']) ? "value='".$arr['value']."'" : '';
        $required = isset($arr['required']) ? "required='".$arr['required']."'" : '';
        $label = isset($arr['label']) ? "<label for='".$arr['id']."' >".$arr['label']."</label>" : '';
        $div_class= isset($arr['div_class']) ? "class='".$arr['div_class']."'" : '';

        if($arr['type'] == 'radio' || $arr['type'] == 'checkbox'){
                $type = "type='".$arr['type']."'";
                $input = "<div $div_class>";
                $title = isset($arr['title']) ? "<div class='rcTitle'>".$arr['title']."</div>":'';
                $input .= $title;
                foreach($arr['choices'] as $choice){
                    $input .= "<input $type ";
                    $input_id = "id='".$choice['id']."'";
                    $input_class= isset($choice['input_class']) ? "class='".$choice['input_class']."'" : '';
                    $value ="value='".$choice['value']."'";
                    $checked = isset($choice['checked']) ? "checked=".$choice['checked'] : '';
                    $label = "<label for='".$choice['id']."' >".$choice['label']."</label>";
                    $input .= " $input_id $input_class $name $value $checked/>".$label;
                }
                $input.="</div>";
        } else{
                $type = "type='".$arr['type']."'";
                $input_class= isset($arr['input_class']) ? "class='".$arr['input_class']."'" : '';
                $input = "<div $div_class><input $type $input_id $input_class $name $placeholder $value $required />".$label."</div>";
        };

        $this->html .= $input;
    }

    public function createTextArea($arr)
    {
        $cols = isset($arr['cols']) ? "cols='".$arr['cols']."'" : '';
        $rows = isset($arr['rows']) ? "rows='".$arr['rows']."'" : '';
        $placeholder =isset($arr['placeholder']) ? "placeholder='".$arr['placeholder']."'" : '';
        $maxlength = isset($arr['maxlength']) ? "maxlength='".$arr['maxlength']."'" : '';
        $required = isset($arr['required']) ? "required='".$arr['required']."'" : '';
        $div_class= isset($arr['div_class']) ? "class='".$arr['div_class']."'" : '';

        $txtarea = "<div $div_class><textarea $cols $rows $placeholder $maxlength $required></textarea></div>";
        $this->html .= $txtarea;
    }
    
    public function createSelect($select_name='', $select_id='', $arr, $div_class='')
    {
        $select_id = !empty($select_id) ? "id='$select_id'" : '';        
        $select_name = !empty($select_name) ? "name='$select_name'" : '';
        $div_class= !empty($div_class) ? "class='$div_class'" : '';
        $select = "<div $div_class><select $select_name $select_id>";

        foreach($arr as $opt_key => $opt_val){
            $select .= "<option value='$opt_key'>$opt_val</option>"; 
        }
        $select .= "</select></div>";
        $this->html .= $select;
    }

    public function makeForm(){
        if($this->fieldset_bool){
            $this->html .="</fieldset>";
        }
        $this->html .="</form>";
        return $this->html;
    }

}   