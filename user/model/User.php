<?php
namespace User\Model;
class User {
    private $maphper;
    private $validator;
    private $security;
    private $status;
    private $defaultAttributes = ['id', 'first_name', 'last_name', 'username', 'email',
        'password', 'security_question', 'security_answer'];
    private $userAttributes;

    public function __construct(\Maphper\Maphper $maphper, \Respect\Validation\Rules\AllOf $validator,
                                    Security $security, Status $status, $additionalUserAttributes = []) {
        $this->maphper = $maphper;
        $this->validator = $validator;
        $this->security = $security;
        $this->status = $status;
        $this->userAttributes = array_merge($this->defaultAttributes, $additionalUserAttributes);
    }

    public function getUsers() {
        return $this->maphper;
    }

    public function validatePasswordConfirm($password, $passwordConfirm) {
        $validator = (new \Respect\Validation\Validator())->equals($passwordConfirm);
        return $validator->validate($password);
    }

    public function create($data) {
        if ($this->user_exists(['username' => $data['username']]) !== false) return false;
        if (!$this->validatePasswordConfirm($data['password'], $data['password_confirm'])) return false;
        if ($data = $this->save($data)) {
            return $status->setSigninVar($data->id);
        }
        else return false;
    }

    public function save(array $data, $id = null) {
        $data = $this->removeExcessAttributes($data);
        $data = (object) $this->security->hashSecurityProperties($data);
        if ($id !== null) $data = (object) array_merge((array)$this->maphper[$id], (array)$data);
        if (!$this->validator->assert((array)$data)) return false;
        if ($this->user_exists(['username' => $data->username]) !== false && $data->username !== $this->getCurrentUser()->username) return false;
        $this->maphper[$id] = $data;
        return $data;
    }

    public function updateCurrentUser($data) {
        return $this->save($data, $status->getSigninVar());
    }

    private function removeExcessAttributes(array $data): array {
        return array_filter($data, function ($key) {
            return in_array($key, $this->userAttributes);
        }, ARRAY_FILTER_USE_KEY);
    }

    public function user_exists($filter) {
        $user = $this->maphper->filter($filter)->limit(1)->item(0);
        if (empty($user)) return false;
        else return $user;
    }

    public function getCurrentUser() {
        if (!$status->getSigninVar()) return false;
        return $this->maphper[$status->getSigninVar()];
    }
}
