<?php
use BasicUser\Model\{Credentials, Hash};

class MockGetUser implements \Solleer\User\User {
    private $data;

    public function __construct($data = []) { $this->data = $data; }

    public function save(array $data, $id = null) {}

    public function getUser($selector) { return $this->data; }
    public function delete($selector) {}
}

class CredentialsTest extends PHPUnit\Framework\TestCase {
    public function testNonexistantUser() {
        $hashMock = $this->getMockBuilder(Hash::class)
                         ->setMethods(['hashValue'])
                         ->getMock();

        $user = new MockGetUser(false);

        $credentials = new Credentials($user, $hashMock);

        $result = $credentials->validateUserCredential(1, 'test');

        $this->assertEquals(false, $result);
    }

    public function testInvalidHash() {
        $hashMock = $this->getMockBuilder(Hash::class)
                         ->setMethods(['verifyHash'])
                         ->getMock();
        $hashMock->expects($this->once())
                 ->method('verifyHash')
                 ->with($this->equalTo('passwordValue'), $this->equalTo('passwordHash'))
                 ->willReturn(false);

        $user = $this->getMockBuilder(MockGetUser::class)
                          ->setMethods(['getUser'])
                          ->getMock();
        $user->expects($this->once())
                  ->method('getUser')
                  ->with($this->equalTo(1))
                  ->willReturn((object) ['password' => 'passwordValue']);

        $credentials = new Credentials($user, $hashMock);

        $result = $credentials->validateUserCredential(1, 'passwordHash');

        $this->assertEquals(false, $result);
    }

    public function testValiddHash() {
        $hashMock = $this->getMockBuilder(Hash::class)
                         ->setMethods(['verifyHash'])
                         ->getMock();
        $hashMock->expects($this->once())
                 ->method('verifyHash')
                 ->with($this->equalTo('passwordValue'), $this->equalTo('passwordValue'))
                 ->willReturn(true);

        $user = $this->getMockBuilder(MockGetUser::class)
                          ->setMethods(['getUser'])
                          ->getMock();
        $user->expects($this->once())
                  ->method('getUser')
                  ->with($this->equalTo(1))
                  ->willReturn((object) ['id' => 1, 'password' => 'passwordValue']);

        $credentials = new Credentials($user, $hashMock);

        $result = $credentials->validateUserCredential(1, 'passwordValue');

        $this->assertEquals(1, $result);
    }
}
