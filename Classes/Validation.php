<?php

class Validation{
    private $_errors = [],
            $_passed = false;

    public function check($items = [])
    {
        $user    = new User;
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {
                switch ($rule) {
                    case 'required':
                        if ( trim(Input::get($item)) == false ) {
                            $this->addError($item, "$item wajib diisi!");
                        }
                        break;
                    case 'min':
                        if (strlen(Input::get($item)) < $rule_value) {
                            $this->addError($item, "$item minimal $rule_value karakter");
                        }
                        break;
                    case 'max':
                        if (strlen(Input::get($item)) > $rule_value) {
                            $this->addError( $item, "$item maximal $rule_value karakter");
                        }
                        break;
                    case 'char':
                        if (!preg_match($rule_value, Input::get($item))) {
                            $this->addError( $item, "karakter pada $item tidak valid!");
                        }
                        break;
                    case 'unique':
                        if ( $user->getUser($item, Input::get($item)) != false ) {
                            $this->addError($item, "$item sudah terdaftar di database");
                        }
                        break;
                    case 'match':
                        if ( Input::get($item) != Input::get('password') ) {
                            $this->addError($item, "konfirmasi password tidak sama!");
                        }
                        break;
                    default:
                        break;
                }
            }
        }
        if (empty($this->_errors)) {
            $this->_passed = true;
        }

        return $this;
    }

    private function addError($key, $val){
        $this->_errors[$key] = $val;
    }

    public function errors()
    {
        return $this->_errors;
    }

    public function passed()
    {
        return $this->_passed;
    }
}