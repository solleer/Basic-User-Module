<?php

namespace User\Model\Form;

class ResetPassword implements \MVC\Model\Form {
    private $resetToken;
    private $user;
    private $credentials;
    public $data = false;
    public $submitted = false;
    public $successful = false;

    public function __construct(\User\Model\ResetToken $resetToken, \User\Model\CurrentUser $user, \User\Model\Credentials $credentials) {
        $this->resetToken = $resetToken;
        $this->user = $user;
        $this->credentials = $credentials;
    }

    public function main($token) {
        if ($id = $this->resetToken->getUserIDofToken($token))
            $this->data = $this->user->getUser($id);
        $this->data->token = $token;
    }

    public function submit($data) {
        $this->submitted = true;
        $id = $this->resetToken->getUserIDofToken($data['token']);
        if (!$this->credentials->validateUserCredential($id, 'security_answer', $data['security_answer'])) return false;
        if ($data['new_password'] !== $data['new_password_confirm') return false;

        return $this->model->updateCurrentUser(['password' => $data['new_password']]);
    }

    public function success() {
        $this->successful = true;
    }
}
