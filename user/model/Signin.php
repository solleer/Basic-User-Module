<?php
namespace User\Model;
class Signin {
    private $model;
    private $status;

    public function __construct(Credentials $model, Status $status) {
        $this->model = $model;
        $this->status = $status;
    }

    public function signin($username, $password) {
        $id = $this->model->validateUserCredential($username, $password);
        if ($id !== false) {
            return $this->status->setSigninVar($id);
        }
        else return false;
    }

    public function signout() {
        $this->status->setSigninVar(null);
        return true;
    }
}
