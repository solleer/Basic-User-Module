<?php

namespace User\Model\Form;

class ResetPasswordBefore implements \MVC\Model\Form {
    private $model;
    private $reset_mailer;
    private $user_token;
    public $successful = false;
    public $submitted = false;
    public $data;

    public function __construct(\User\Model\User $model, \User\Model\EmailResetPassword $reset_mailer,
                                  \User\Model\SecurityToken $user_token) {
        $this->model = $model;
        $this->reset_mailer = $reset_mailer;
        $this->user_token = $user_token;
    }

    public function main($id) {
        $this->submitted = false;
        return true;
    }

    public function submit($data) {
        $this->submitted = true;
        $user = $this->model->user_exists($data);
        
        if ($user === false) return false;

        $token = $this->user_token->generate_token($user->user_id);
        return $this->reset_mailer->send($user->email, $token);
    }

    public function success() {
        $this->successful = true;
    }
}
