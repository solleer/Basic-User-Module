<?php
namespace BasicUser\Model;
class Signin {
    private $model;
    private $status;

    public function __construct(Credentials $model, \Solleer\User\SigninStatus $status) {
        $this->model = $model;
        $this->status = $status;
    }

    public function signin($username, $password) {
        $id = $this->model->validateUserCredential($username, $password);
        if ($id !== false) return $this->status->setSigninID($id);
        else return false;
    }

    public function signout() {
        $this->status->setSigninID(null);
        return true;
    }
}
