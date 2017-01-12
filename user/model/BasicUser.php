<?php
namespace User\Model;
class BasicUser implements User {
    private $maphper;
    private $validator;
    private $security;
    private $defaultAttributes = ['id', 'first_name', 'last_name', 'username', 'email',
        'password', 'security_question', 'security_answer'];
    private $userAttributes;
    private $securityProperties = [
        'password',
        'security_answer'
    ];

    public function __construct(\Maphper\Maphper $maphper, \Respect\Validation\Rules\AllOf $validator,
                                    Security $security, $additionalUserAttributes = []) {
        $this->maphper = $maphper;
        $this->validator = $validator;
        $this->security = $security;
        $this->userAttributes = array_merge($this->defaultAttributes, $additionalUserAttributes);
    }

    public function save(array $data, $id = null) {
        $data = $this->removeExcessAttributes($data);
        $data = (object) $this->hashSecurityProperties($data);
        if ($id !== null) $data = (object) array_merge((array)$this->getUser($id), (array)$data);
        if (!$this->validator->validate((array)$data)) return false;
        if ($this->getUser($data->username) !== false && $data->username !== $this->getUser($id)->username) return false;
        $this->maphper[$id] = $data;
        return $data;
    }

    private function removeExcessAttributes(array $data): array {
        return array_filter($data, function ($key) {
            return in_array($key, $this->userAttributes);
        }, ARRAY_FILTER_USE_KEY);
    }

    private function hashSecurityProperties(array $data): array {
        foreach ($data as $key => $value) {
            if (in_array($key, $this->securityProperties)) {
                $data[$key] = $this->security->hashValue($data[$key]);
            }
        }
        return $data;
    }

    public function getUser($selector) {
        // Select by Id
        if (is_numeric($selector)) $user = $this->maphper[$selector];
        // Select by username
        else $user = $this->maphper->filter(['username' => $selector])->limit(1)->item(0);
        if (empty($user)) return false;
        else return $user;
    }
}
