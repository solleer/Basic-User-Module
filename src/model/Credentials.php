<?php
namespace BasicUser\Model;

class Credentials {
    private $model;
    private $status;
    private $hash;

    public function __construct(\User\Model\User $model, \User\Model\SigninStatus $status, Hash $hash) {
        $this->model = $model;
        $this->status = $status;
        $this->hash = $hash;
    }

    public function checkCurrentUserPassword($username, $password) {
        $id = $this->validateUserCredential($username, $password);

        return $id && $id === $this->status->getSigninID();
    }

    public function validateUserCredential($userSelector, $valueEntered, $property = 'password') {
        $user = $this->model->getUser($userSelector);
        if (empty($user)) return false;
        if ($this->hash->verifyHash($user, $property, $password)) return $user->id;
        else return false;
    }
}
