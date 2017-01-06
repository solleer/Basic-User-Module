<?php
namespace User\Model;

class Credentials {
    private $model;
    private $status;
    private $security;

    public function __construct(User $model, Status $status, Security $security) {
        $this->model = $model;
        $this->status = $status;
        $this->security = $security;
    }

    public function checkCurrentUserSecurity($username, $password) {
        $id = $this->signin_credentials($username, $password);

        if ($id === false || $id !== $status->getSigninVar()) return false;
        return true;
    }

    public function signin_credentials($username, $password) {
        return $this->validateUserCredential($username, 'password', $password);
    }

    public function validateUserCredential($userSelector, $property, $valueEntered) {
        $user = $this->model->getUser($userSelector);
        if (empty($user)) return false;
        if ($security->verifyHash($user, $property, $password)) return $user->id;
        else return false;
    }
}
