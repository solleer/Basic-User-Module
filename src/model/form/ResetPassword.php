<?php

namespace BasicUser\Model\Form;

class ResetPassword implements \MVC\Model\Form {
    private $resetToken;
    private $user;
    private $credentials;
    public $data = false;
    public $submitted = false;
    public $successful = false;

    public function __construct(\Token\Generator $resetToken, \Solleer\User\User $user, \BasicUser\Model\Credentials $credentials) {
        $this->resetToken = $resetToken;
        $this->user = $user;
        $this->credentials = $credentials;
    }

    public function main($data) {
        $token = $data[0] ?? '';
        if ($id = $this->resetToken->getTokenData($token)['user_id'])
            $this->data = $this->user->getUser($id);
        $this->data->token = $token;
    }

    public function submit($data) {
        $this->submitted = true;
        $id = $this->resetToken->getTokenData($data['token'])['user_id'];
        if (!$this->credentials->validateUserCredential($id, $data['security_answer'], 'security_answer')) return false;
        if ($data['new_password'] !== $data['new_password_confirm') return false;

        return $this->model->save(['password' => $data['new_password']], $id);
    }

    public function success() {
        $this->successful = true;
    }
}
