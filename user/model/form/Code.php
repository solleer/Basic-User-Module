<?php
namespace BasicUser\Model\Form;
class Code implements \MVC\Model\Form {
    public $submitted = false;
    public $successful = false;
    private $codeModel;
    private $userModel;
    private $groupModel;

    public function __construct(\BasicUser\Model\Code $codeModel, \User\Model\CurrentUser $userModel, \Maphper\Maphper $groupModel) {
        $this->codeModel = $codeModel;
        $this->userModel = $userModel;
        $this->groupModel = $groupModel;
    }

    public function main($data) {
        return;
    }

    public function submit($data) {
        $this->submitted = true;
        $code = $data['code'];
        $purpose = $this->codeModel->redeemCode($code);
        if (!$purpose) return false;
        $user = $this->userModel->getCurrentUser();
        $user->groups[] = $this->groupModel->filter(["name" => $purpose])->item(0);
        return true;
    }

    public function success() {
        $this->successful = true;
    }
}
