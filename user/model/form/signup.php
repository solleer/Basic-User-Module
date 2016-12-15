<?php

namespace User\Model\Form;

class Signup implements \MVC\Model\Form {
    private $model;
    private $code;
    public $successful = false;
    public $submitted = false;
    public $data;

    public function __construct(\User\Model\User $model, \User\Model\Code $code) {
        $this->model = $model;
        $this->code = $code;
    }

    public function main($data) {
        $this->submitted = false;
        return true;
    }

    public function submit($data) {
        $this->submitted = true;
        ///if (!isset($data['code']) || !$this->code->redeemCode($data['code'], 'pay')) return false;
        if ($this->model->create($data) == true) {
            return true;
        }
        else {
            //$this->code->addCode($data['code']);
            return false;
        }
    }

    public function success() {
        $this->successful = true;
    }
}
