<?php
namespace BasicUser\Model\Form;
class ChangePassword implements \MVC\Model\Form {
    private $model;
    private $credentials;
    public $successful = false;
    public $submitted = false;

    public function __construct(\Solleer\User\CurrentUser $model, \BasicUser\Model\Credentials $credentials) {
        $this->model = $model;
        $this->credentials = $credentials;
    }

    public function main($id) {
        $this->submitted = false;
        return true;
    }

    public function submit($data) {
        $this->submitted = true;
        if (!$this->credentials->checkCurrentUserPassword($data['username'], $data['password'])) return false;
        if ($data['new_password'] !== $data['new_password_confirm') return false;

        return $this->model->updateCurrentUser(['password' => $data['new_password']]);
    }

    public function success() {
        $this->successful = true;
    }
}
