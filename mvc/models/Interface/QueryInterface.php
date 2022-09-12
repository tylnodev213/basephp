<?php

interface QueryInterface
{
	function getAll($fields);
	function findById($id);
	function deleteById($id);
	function create($data);
	function update($id,$data);
	function find($email,$name);
}