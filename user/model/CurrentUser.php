<?php

namespace User\Model;

class CurrentUser {
    private $user;
    private $status;

    public function __construct(\User\Model\User $user, Status $status) {
        $this->user = $user;
        $this->model = $model;
    }

    public function updateCurrentUser(array $data) {
        return $this->save($data, $this->status->getSigninVar());
    }

    public function getCurrentUser() {
        return $this->getUser($this->status->getSigninVar());
    }
}
