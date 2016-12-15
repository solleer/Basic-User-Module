<?php
namespace User\Controller;
class Ajax {
    private $model;

    public function __construct(\User\Model\User $model) {
        $this->model = $model;
    }

    public function user_exists() {
        $username = $_POST['username'];
        $user = $this->model->user_exists(['username' => $username]);
        echo json_encode(empty($user));
        exit;
    }
}
