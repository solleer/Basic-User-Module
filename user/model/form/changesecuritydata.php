<?php
namespace BasicUser\Model\Form;
class ChangeSecurityData implements \MVC\Model\Form {
    private $model;
    private $credentials;
    public $successful = false;
    public $submitted = false;

    public function __construct(\User\Model\CurrentUser $model, \BasicUser\Model\Credentials $credentials) {
        $this->model = $model;
        $this->credentials = $credentials;
    }

    public function main($id) {
        $this->submitted = false;
        return true;
    }

    public function submit($data) {
        $this->submitted = true;
        if (!$this->credentials->checkCurrentUserSecurity($data['username'], $data['password'])) return false;

        return $this->model->updateCurrentUser([
            'security_question' => $data['security_question'],
            'security_answer' => $data['security_answer']
        ]);
    }

    public function success() {
        $this->successful = true;
    }
}
