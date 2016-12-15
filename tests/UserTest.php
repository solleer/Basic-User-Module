<?php
use User\Model\{User, Security, Status};
use Maphper\Maphper;
class UserTest extends PHPUnit_Framework_TestCase {

    private function getValidation() {
        $loader = new Dice\Loader\Json;
        $dice = $loader->load('user/dice.json');
        return $dice->create('$user_validate_user');
    }

    private function filterOutSecurity(array $data): array {
        return array_filter($data, function ($key) {
            return !in_array($key, ['security_answer', 'password']);
        }, ARRAY_FILTER_USE_KEY);
    }

    public function testSave() {
        $storage = new \ArrayObject();
        $maphper = new Maphper(new \Maphper\DataSource\Mock($storage, 'id'));

        $user = new User($maphper, $this->getValidation(), new Security, new Status);

        $data = [
            'username' => 'test1',
            'first_name' => 'foo',
            'last_name' => 'bar',
            'password' => 'test',
            'email' => 'foo@bar.com',
            'security_question' => 'What is the module name?',
            'security_answer' => 'user'
        ];

        $user->save($data);

        $this->assertEquals($this->filterOutSecurity($data), $this->filterOutSecurity((array)$storage[0]));
    }
}
