<?php
namespace User\Model;

class Status {
    public function setSigninVar($id) {
        $_SESSION['user_id'] = $id;
        return true;
    }

    public function getSigninVar() {
        return $_SESSION['user_id'];
    }
}
