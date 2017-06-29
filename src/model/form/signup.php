<?php
namespace BasicUser\Model\Form;
use Solleer\User\{User, SigninStatus};
class Signup implements \MVC\Model\Form {
    private $model;
    private $status;
    public $successful = false;
    public $submitted = false;
    public $newId;

    public function __construct(User $model, SigninStatus $status) {
        $this->model = $model;
        $this->status = $status;
        $this->code = $code;
    }

    public function main($data) {
        $this->submitted = false;
        return true;
    }

    public function submit($data) {
        $this->submitted = true;
        if ($data['password'] !== $data['password_confirm']) return false;
        $this->newId = $this->model->save($data)->id;
        return $this->newId !== false;
    }

    public function success() {
        $this->status->setSigninID($this->newId);
        $this->successful = true;
    }
}
