<?php
namespace User\Model;
class EmailResetPassword {
    private $mailer;
    private $rand_generator;

    public function __construct(\PHPMailer $mailer/*, \Utils\RandomStringGenerator $rand_generator*/) {
        $this->mailer = $mailer;
        $this->rand_generator = $rand_generator;
    }

    public function sendResetEmail($email, $token) {

        $this->mailer->setFrom();

    }
}
