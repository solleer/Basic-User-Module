<?php

namespace User\Model\Form;

class Signup implements \MVC\Model\Form {
    private $model;
    private $code;
    private $status;
    public $successful = false;
    public $submitted = false;
    public $data;

    public function __construct(\User\Model\User $model, \User\Model\Status $status, \User\Model\Code $code) {
        $this->model = $model;
        $this->status = $status;
        $this->code = $code;
    }

    public function main($data) {
        $this->submitted = false;
        return true;
    }

    public function submit($data) {
        $this->submitted = true;
        if ($data['password'] !== $data['password_confirm']) return false;
        ///if (!isset($data['code']) || !$this->code->redeemCode($data['code'], 'pay')) return false;
        if ($this->data = $this->model->save($data)->id) {
            return true;
        }
        else {
            //$this->code->addCode($data['code']);
            return false;
        }
    }

    public function success() {
        $this->status->setSigninVar($this->data);
        $this->successful = true;
    }
}
