<?php
Class Validation{
    
    protected $errors = [];
   
    public function required($req_fields){
        foreach($req_fields as $field) :
            $field_name = $field['name'];
            $field_value = trim($field['value']);
            $err_msg = isset($field['msg']) ? $field['msg'] : 'Required!';
            
            if($field_value == '' || $field_value == null){
                $this->errors["$field_name"]=$err_msg;
            }
            if(!empty($field['match'])){
                $this->equal_to($field, $err_msg);
            }
        endforeach;
        
        return $this;
    }
    
    private function equal_to($arr_fields,$err_msg='It does not match!'){
        // $field_source_name = $arr_fields['match'];
        $field_source_value = $arr_fields['source_value'];
        $field_target_name = $arr_fields['name'];
        $field_target_value = $arr_fields['value'];
        
        if($field_source_value != $field_target_value){
            $this->errors[$field_target_name] = $err_msg;
        }
    }

    public function success(){
        return empty($this->errors);
    }
    
    public function get_errors(){
        if(!$this->success()) return $this->errors;
    }
    
    public function is_email($value){
        if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
            $this->errors['email']='Please enter a valid email address';
        }
    }
}