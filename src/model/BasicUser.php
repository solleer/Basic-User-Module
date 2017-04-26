<?php
namespace BasicUser\Model;
use Respect\Validation\Rules\AllOf as ValidationAllOf;
class BasicUser implements \User\Model\User {
    private $maphper;
    private $validator;
    private $hash;
    private $defaultAttributes = ['id', 'first_name', 'last_name', 'username', 'email',
        'password', 'security_question', 'security_answer'];
    private $userAttributes;
    private $hashProperties = [
        'password',
        'security_answer'
    ];

    public function __construct(\Maphper\Maphper $maphper, ValidationAllOf $validator, Hash $hash, $additionalUserAttributes = []) {
        $this->maphper = $maphper;
        $this->validator = $validator;
        $this->hash = $hash;
        $this->userAttributes = array_merge($this->defaultAttributes, $additionalUserAttributes);
    }

    public function save(array $data, $id = null) {
        $data = $this->removeExcessAttributes($data);
        $data = (object) $this->hashUserProperties($data);
        // If the user is being updated then add missing properties so it passes validation
        if ($id !== null && $this->getUser($id)) $data = (object) array_merge((array)$this->getUser($id), (array)$data);
        if (!$this->validator->validate((array)$data)) return false;
        // If the user exists and is changing their username only allow it if the new one is not taken
        if ($this->getUser($data->username) !== false && $data->username !== $this->getUser($id)->username) return false;
        $this->maphper[$id] = $data;
        return $data;
    }

    private function removeExcessAttributes(array $data): array {
        return array_filter($data, function ($key) {
            return in_array($key, $this->userAttributes);
        }, ARRAY_FILTER_USE_KEY);
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
        // Select by Id
        if (is_numeric($selector)) $user = $this->maphper[$selector];
        // Select by username (The line below makes it require Maphper instead of just ArrayAccess)
        else $user = $this->maphper->filter(['username' => $selector])->limit(1)->item(0);
        if (empty($user)) return false;
        else return $user;
    }
}
