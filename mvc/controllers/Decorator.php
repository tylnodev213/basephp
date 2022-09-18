<?php

abstract class Decorator implements ActionInterface
{
    protected ActionInterface $action;

    public function __construct(ActionInterface $action)
    {
        $this->action = $action;
    }

    public function login() {}

    public function search() {}

    public function create() {}

    public function edit($id) {}

    public function delete($id) {}

    public function logout() {}
}