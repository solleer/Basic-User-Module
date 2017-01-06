<?php
namespace User\Model\Form;
class Edit implements \MVC\Model\Form {
    private $model;
    public $successful = false;
    public $submitted = false;
    public $data = [];
    private $updatableProps = [
        'first_name', 'last_name', 'email', 'username'
    ];

    public function __construct(\User\Model\User $model) {
        $this->model = $model;
    }

    public function main($data = null) {
        $this->submitted = false;
        $user = $this->model->getCurrentUser();
        if (empty($user)) return;
        $this->data = $user;
    }

    public function submit($data) {
        $this->submitted = true;
        return $this->model->updateCurrentUser(array_filter($data, function ($key) {
            return !in_array($key, $this->updatableProps);
        }, ARRAY_FILTER_USE_KEY));
    }

    public function success() {
        $this->successful = true;
    }
}
