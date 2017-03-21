<?php

namespace BasicUser\Model\Form;

class SendResetPassword implements \MVC\Model\Form {
    private $model;
    private $mailer;
    private $token;
    private $tokenMaker;
    private $user;
    private $request;
    public $successful = false;
    public $submitted = false;

    public function __construct(\User\Model\User $model, \MVC\Model\Emailer $mailer,
                                  \BasicUser\Model\ResetToken $tokenMaker, \Utils\Request $request) {
        $this->model = $model;
        $this->mailer = $mailer;
        $this->tokenMaker = $tokenMaker;
        $this->request = $request;
    }

    public function main($id) {
        $this->submitted = false;
        return true;
    }

    public function submit($data) {
        $this->submitted = true;
        $this->user = $this->model->getUser($data['username']);

        if ($user === false) return false;

        $this->token = $this->tokenMaker->generateToken($this->user->id);
        return true;
    }

    public function success() {
        $this->mailer->send($this->user->email, ['token' => $this->token, 'request' => $this->request]);
        $this->successful = true;
    }
}
