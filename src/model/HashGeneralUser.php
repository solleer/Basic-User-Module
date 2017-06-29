<?php
namespace BasicUser\Model;
class HashGeneralUser implements \User\Model\User {
    private $user;
    private $hash;
    private $hashProperties;

    public function __construct(\User\Model\User $user, Hash $hash, array $hashProperties) {
        $this->user = $user;
        $this->hash = $hash;
        $this->hashProperties = $hashProperties;
    }

    public function save(array $data, $id = null) {
        return $this->user->save($this->hashUserProperties($data), $id);
    }

    private function hashUserProperties(array $data): array {
        foreach ($data as $key => $value) {
            if (in_array($key, $this->hashProperties)) {
                $data[$key] = $this->hash->hashValue($data[$key]);
            }
        }
        return $data;
    }

    public function getUser($selector) {
        return $this->user->getUser($selector);
    }
}
