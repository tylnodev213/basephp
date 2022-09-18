<?php

interface QueryInterface
{
	function findById($id,$nameField);
	function deleteById($id);
	function create($data);
	function update($id,$data);
	function searchData($conditions = [], $getResult);
}