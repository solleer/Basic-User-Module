<?php
class HashTest extends PHPUnit\Framework\TestCase {
    public function testHashValue() {
        $hash = new BasicUser\Model\Hash();

        $value = "password";
        $this->assertNotEquals($value, $hash->hashValue($value));
    }

    public function testVerifyHash() {
        $hash = new BasicUser\Model\Hash();

        $value = "password";
        $hashedValue = $hash->hashValue($value);
        $this->assertTrue($hash->verifyHash($hashedValue, $value));
    }
}
