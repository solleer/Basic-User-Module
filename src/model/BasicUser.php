<?php
namespace BasicUser\Model;
use Respect\Validation\Rules\AllOf as ValidationAllOf;
class BasicUser implements \Solleer\User\User {
    private $maphper;
    private $validator;
    private $defaultAttributes = ['id', 'username'];
    private $userAttributes;

    public function __construct(\Maphper\Maphper $maphper, ValidationAllOf $validator, $additionalUserAttributes = []) {
        $this->maphper = $maphper;
        $this->validator = $validator;
        $this->userAttributes = array_merge($this->defaultAttributes, $additionalUserAttributes);
    }

    public function save(array $data, $id = null) {
        $data = (object) $this->removeExcessAttributes($data);
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

    public function getUser($selector) {
        // Select by Id
        if (is_numeric($selector)) $user = $this->maphper[$selector];
        // Select by username (The line below makes it require Maphper instead of just ArrayAccess)
        else $user = $this->maphper->filter(['username' => $selector])->limit(1)->item(0);
        if (empty($user)) return false;
        else return $user;
    }

    public function delete($selector) {
        // Delete by Id
        if (is_numeric($selector)) unset($this->maphper[$selector]);
        // Delete by username (The line below makes it require Maphper instead of just ArrayAccess)
        else $user = $this->maphper->filter(['username' => $selector])->limit(1)->delete();
        return true;
    }
}
