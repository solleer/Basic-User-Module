<?php
namespace BasicUser\Controller;
class Ajax {
    private $model;
    private $request;

    public function __construct(\User\Model\User $model, \Utils\Request $request) {
        $this->model = $model;
        $this->request = $request;
    }

    public function user_exists() {
        $username = $this->request->post('username');
        $user = $this->model->getUser($username);
        echo json_encode(empty($user));
        exit;
    }
}
