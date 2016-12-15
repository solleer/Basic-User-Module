<?php
abstract class Website_Framework_TestCase extends PHPUnit_Framework_TestCase {/*
    private $dice;
    private $router;
    private $testModule;

    public function setUp() {
        $diceLoader = new Dice\Loader\Json();
        $this->dice = $diceLoader->load(['tests/deps/Config/Framework.json', "user/dice.json"]);

        $this->router = new Level2\Router\Router;
        $this->router->addRule(new Config\Router\ModuleJson($this->dice, ''));
    }

    private function getRoute(array $route) {
        return $this->router->find($this->testModule . '/' . $route);
    }*/
}
