<?php
namespace BasicUser\Model;

class Credentials {
    private $model;
    private $status;
    private $security;

    public function __construct(\User\Model\User $model, \User\Model\SigninStatus $status, Security $security) {
        $this->model = $model;
        $this->status = $status;
        $this->security = $security;
    }

    public function checkCurrentUserSecurity($username, $password) {
        $id = $this->validateUserCredential($username, $password);

        return $id && $id === $this->status->getSigninID();
    }

    public function validateUserCredential($userSelector, $valueEntered, $property = 'password') {
        $user = $this->model->getUser($userSelector);
        if (empty($user)) return false;
        if ($security->verifyHash($user, $property, $password)) return $user->id;
        else return false;
    }
}
