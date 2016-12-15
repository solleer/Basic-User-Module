<?php
namespace User\Model\Authorize;
class User implements \User\Model\Authorizable {
    public function authorize($user, array $args): bool {
        if (!empty($user)) return true;
        else return false;
    }
}
