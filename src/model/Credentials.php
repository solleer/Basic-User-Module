<?php
namespace BasicUser\Model;

class Credentials {
    private $model;
    private $status;
    private $hash;

    public function __construct(\Solleer\User\User $model, Hash $hash) {
        $this->model = $model;
        $this->hash = $hash;
    }

    public function validateUserCredential($userSelector, $valueEntered, $property = 'password') {
        $user = $this->model->getUser($userSelector);
        if (empty($user)) return false;
        if ($this->hash->verifyHash($user, $property, $password)) return $user->id;
        else return false;
    }
}
