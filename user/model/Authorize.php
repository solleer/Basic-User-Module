<?php
namespace User\Model;
class Authorize {
    private $model;
    private $currentUser;
    private $functions = [];
    private $defaultFunctions = [
        "user" => "\\User\\Model\\Authorize\\User"
    ];
    private $id = false;

    public function __construct(User $model, $currentUser) {
        $this->model = $model;
        $this->currentUser = $currentUser;
        foreach ($this->defaultFunctions as $key => $function) $this->addFunction($key, new $function);
    }

    public function __call($name, $args) {
		if (isset($this->functions[$name])) {
            if ($this->id) $user = $this->model->getUser($this->id);
            else $user = $this->currentUser;

			$result = $this->functions[$name]->authorize($user, $args);
            $this->id = false;
            return $result;
		}
		throw new \Exception("Method \\User\\Model\\Authorize::" . $name . " does not exist");
	}

    public function id($id) {
        $this->id = $id;
        return $this;
    }

    public function addFunction($name, Authorizable $function) {
		$this->functions[$name] = $function;
	}
}
