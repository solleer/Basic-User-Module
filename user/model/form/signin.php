<?php

namespace User\Model\Form;

class Signin implements \MVC\Model\Form {
    private $model;
    public $successful = false;
    public $submitted = false;
    public $data;

    public function __construct(\User\Model\Signin $model) {
        $this->model = $model;
    }

    public function main($data) {
        $this->submitted = false;
        return true;
    }

    public function submit($data) {
        $this->submitted = true;
        if (empty($data['username']) || empty($data['password'])) return false;
        return $this->model->signin($data['username'], $data['password']);
    }

    public function success() {
        $this->successful = true;
    }
}
