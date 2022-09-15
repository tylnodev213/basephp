<?php

interface QueryInterface
{
	function findById($id);
	function deleteById($id);
	function create($data);
	function update($id,$data);
	function searchData($conditions = [], $getResult);
}