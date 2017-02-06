<?php
namespace User\Model;
class Code {
    private $mapper;
    private $codeGenerator;

    public function __construct(\ArrayAccess $mapper, \Utils\RandomStringGenerator $codeGenerator) {
        $this->mapper = $mapper;
        $this->codeGenerator = $codeGenerator;
    }

    public function generateCode($purpose) {
        $code = $this->codeGenerator->generate(20);
        if ($this->addCode($code, $purpose)) return $code;
    }

    public function addCode($code, $purpose) {
        $this->mapper[$code] = (object) ['purpose' => $purpose];
        return true;
    }

    public function getPurpose($code) {
        return $this->mapper[$code]->purpose ?? false;
    }

    public function redeemCode($code) {
        if (!empty($this->mapper[$code])) {
            $purpose = $this->mapper[$code]->purpose;
            unset($this->mapper[$code]);
            return $purpose;
        }
        else return false;
    }
}
