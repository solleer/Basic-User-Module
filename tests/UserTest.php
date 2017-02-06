<?php
use User\Model\{BasicUser, Security, Status};
use Maphper\Maphper;
use Respect\Validation\Rules\AllOf;
abstract class UserTest extends PHPUnit_Framework_TestCase {
    abstract protected function getSampleUser($id = null): array;

    abstract protected function getUser($storage): \User\Model\User;

    public function testSave() {
        $storage = new \ArrayObject();
        $user = $this->getUser($storage);

        $user->save($this->getSampleUser());

        $this->assertEquals($this->getSampleUser(0), (array)$storage[0]);
    }

    public function testSaveId() {
        $storage = new \ArrayObject();
        $user = $this->getUser($storage);

        $saveId = 5;

        $user->save($this->getSampleUser(), $saveId);

        $this->assertEquals($this->getSampleUser($saveId), (array)$storage[$saveId]);
    }

    public function testGetUserById() {
        $storage = new \ArrayObject([4 => $this->getSampleUser(4)]);
        $user = $this->getUser($storage);

        $this->assertEquals($this->getSampleUser(4), (array)$user->getUser(4));
    }
}
