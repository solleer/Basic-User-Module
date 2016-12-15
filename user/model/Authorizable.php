<?php
namespace User\Model;
interface Authorizable {
    public function authorize($user, array $args): bool;
}
