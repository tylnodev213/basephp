<?php

interface ActionInterface
{
    public function login();
    public function search();
    public function create();
    public function edit($id);
    public function delete($id);
    public function logout();
}