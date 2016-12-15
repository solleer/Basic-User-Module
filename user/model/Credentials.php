<?php
namespace User\Model;

class Credentials {
    private $model;
    private $status;

    public function __construct(User $model, Status $status) {
        $this->model = $model;
        $this->status = $status;
    }

    public function checkCurrentUserSecurity($username, $password) {
        $id = $this->signin_credentials($username, $password);

        if ($id === false || $id !== $status->getSigninVar()) return false;
        return true;
    }

    public function signin_credentials($username, $password) {
        $user = $this->model->user_exists(['username' => $username]);
        if (empty($user)) return false;
        if (password_verify($password, $user->password)) return $user->id;
        else return false;
    }
}
