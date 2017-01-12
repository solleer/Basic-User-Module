<?php
namespace User\Model;
class Code {
    private $maphper;
    private $codeGenerator;

    public function __construct(\Maphper\Maphper $maphper, \Utils\RandomStringGenerator $codeGenerator) {
        $this->maphper = $maphper;
        $this->codeGenerator = $codeGenerator;
    }

    public function generateCode($purpose) {
        $code = $this->codeGenerator->generate(20);

        if ($this->addCode($code, $purpose)) return $code;
    }

    public function addCode($code, $purpose) {
        $this->maphper[] = (object) ['code' => $code, 'purpose' => $purpose];
        return true;
    }

    public function getPurpose($code) {
        return $this->maphper[$code]->purpose ?? false;
    }

    public function redeemCode($code) {
        if (!empty($this->maphper[$code])) {
            $purpose = $this->maphper[$code]->purpose;
            unset($this->maphper[$code]);
            return $purpose;
        }
        else return false;
    }
}
