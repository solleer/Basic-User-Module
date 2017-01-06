<?php
namespace User\Model;
class Security {
    private $properties = [
        'password',
        'security_answer'
    ];
    private $algorithm = PASSWORD_DEFAULT;

    public function hashSecurityProperties($data) {
        foreach ($data as $key => $value) {
            if (in_array($key, $this->properties) && password_needs_rehash($data[$key], $this->algorithm)) {
                $data[$key] = password_hash($data[$key], $this->algorithm);
            }
        }
        return $data;
    }

    public function verifyHash(object $user, $property, $comparison): bool {
        return password_verify($comparison, $user->$property);
    }
}
