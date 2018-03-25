<?php
use BasicUser\Model\{HashGeneralUser, Hash};
class HashUserTest extends PHPUnit\Framework\TestCase {
    public function testSaveUser() {

        $hashMock = $this->getMockBuilder(Hash::class)
                         ->setMethods(['hashValue'])
                         ->getMock();



        // Set up the expectation for the update() method
        // to be called only once and with the string 'something'
        // as its parameter.
        $hashMock->expects($this->once())
                 ->method('hashValue')
                 ->with($this->equalTo('password'))
                 ->willReturn('hashedPassword');

        $mockUser = new MockSaveUser;

        $hashUser = new BasicUser\Model\HashGeneralUser($mockUser, $hashMock, ['password']);
        $hashUser->save(['password' => 'password', 'id' => 1]);

        $this->assertEquals(['password' => 'hashedPassword', 'id' => 1], $mockUser->savedData);
    }
}

class MockSaveUser implements \Solleer\User\User {
    public $savedData;
    public function save(array $data, $id = null) {
        $this->savedData = $data;
    }

    public function getUser($selector) {}
    public function delete($selector) {}
}
