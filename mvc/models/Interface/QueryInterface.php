<?php

interface QueryInterface
{
	function findByField($id,$nameField);
	function deleteById($id);
	function create($data);
	function update($id,$data);
	function searchData($conditions = [], $getResult);
}