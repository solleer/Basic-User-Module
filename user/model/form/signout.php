<?php

namespace BasicUser\Model\Form;

class Signout implements \MVC\Model\Form {
    private $model;
    public $successful = false;
    public $submitted = false;
    public $data;

    public function __construct(\BasicUser\Model\Signin $model) {
        $this->model = $model;
    }

    public function main($data) {
        $this->submitted = false;
        return true;
    }

    public function submit($data) {
        $this->submitted = true;
        return $this->model->signout();
    }

    public function success() {
        $this->successful = true;
    }
}
