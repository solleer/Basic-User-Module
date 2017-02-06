<?php
namespace User\Model;
class ResetToken {
    private $mapper;
    private $rand_generator;

    public function __construct(\ArrayAccess $mapper, \Utils\RandomStringGenerator $rand_generator) {
        $this->mapper = $mapper;
        $this->rand_generator = $rand_generator;
    }

    public function generateToken($user_id) {
        $token = $rand_generator->generate(20);
        $this->mapper[$token] = (object) ['user_id' => $user_id, 'timestamp' => new \DateTime()];
        return $token;
    }

    public function isTokenValid($token): bool {
        if (!isset($this->mapper[$token])) return false;
        $now = new \DateTime();
        $diffHours = $now->diff($this->mapper[$token]->timestamp)->format('rh');
        return -24 < $diffHours && $diffHours < 0;
    }

    public function getUserIDofToken($token) {
        if ($this->isTokenValid($token)) return $this->mapper[$token]->user_id;
        else return false;
    }
}
