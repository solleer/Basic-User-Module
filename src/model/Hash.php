<?php
namespace BasicUser\Model;
class Hash {
    private $algorithm = PASSWORD_DEFAULT;

    public function hashValue($raw) {
        if (password_needs_rehash($raw, $this->algorithm))
            return password_hash($raw, $this->algorithm);
        else
            return $raw;
    }

    public function verifyHash(object $user, $property, $comparison): bool {
        return password_verify($comparison, $user->$property);
    }
}
