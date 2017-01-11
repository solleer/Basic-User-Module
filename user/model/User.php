<?php

namespace User\Model;

interface User {
    public function save(array $data, $id = null);
    public function getUser($selector);
}
