<?php
namespace BasicUser\Model;

class CurrentUserCredentials {
    private $model;
    private $status;

    public function __construct(Credentials $model, \Solleer\User\SigninStatus $status) {
        $this->model = $model;
        $this->status = $status;
    }

    public function validateUserCredential($userSelector, $valueEntered, $property = 'password') {
        $id = $this->model->validateUserCredential($userSelector, $valueEntered, $property);
        return $id && $id === $this->status->getSigninID();
    }
}
