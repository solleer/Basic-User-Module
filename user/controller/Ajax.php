<?php
namespace BasicUser\Controller;
class Ajax {
    private $model;
    private $request;
    private $currentUser;

    public function __construct(\User\Model\User $model, \Utils\Request $request, $currentUser) {
        $this->model = $model;
        $this->request = $request;
        $this->currentUser = $currentUser;
    }

    public function user_exists() {
        $username = $this->request->post('username');
        $user = $this->model->getUser($username);
        echo json_encode(empty($user) || $user === $this->currentUser);
        exit;
    }
}
