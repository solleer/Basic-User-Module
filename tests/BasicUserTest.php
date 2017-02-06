<?php
use User\Model\{BasicUser, Security, Status};
use Maphper\Maphper;
use Respect\Validation\Rules\AllOf;
require_once "UserTest.php";

class BasicUserTest extends UserTest {
    private function getIdField(): string {
        return 'id';
    }

    protected function getSampleUser($id = null, $username = null): array {
        $user = [
            'username' => 'test1',
            'first_name' => 'foo',
            'last_name' => 'bar',
            'password' => 'test',
            'email' => 'foo@bar.com',
            'security_question' => 'What is the module name?',
            'security_answer' => 'user'
        ];
        if ($id) $user[$this->getIdField()] = $id;
        if ($username) $user['username'] = $username;
        return $user;
    }

    private function getValidation() {
        $loader = new Dice\Loader\Json;
        $dice = $loader->load('user/dice.json');
        return $dice->create('$user_validate_user');
    }

    private function getMockSecurity() {
        $stub = $this->createMock(Security::class);
        $stub->method('hashValue')->will($this->returnArgument(0));
        return $stub;
    }

    private function getMockValidation() {
        $stub = $this->createMock(AllOf::class);
        $stub->method('validate')->willReturn(true);
        return $stub;
    }

    protected function getUser($storage): \User\Model\User {
        $maphper = new Maphper(new \Maphper\DataSource\Mock($storage, $this->getIdField()));

        $user = new BasicUser($maphper, $this->getMockValidation(), $this->getMockSecurity());
        return $user;
    }

    public function testGetUserByUsername() {
        $storage = new \ArrayObject([4 => $this->getSampleUser(4, 'foo1'), 1 => $this->getSampleUser(1, 'foo2')]);
        $user = $this->getUser($storage);

        $this->assertEquals($this->getSampleUser(1, 'foo2'), (array)$user->getUser('foo2'));
    }
}
