<?php
namespace User\Model\Form;
class Edit implements \MVC\Model\Form {
    private $model;
    public $successful = false;
    public $submitted = false;
    public $data = [];
    private $updatableProps;

    public function __construct(\User\Model\CurrentUser $model, $updatableProps) {
        $this->model = $model;
        $this->updatableProps = $updatableProps;
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
