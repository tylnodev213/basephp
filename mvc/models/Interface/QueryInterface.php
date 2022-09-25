<?php

interface QueryInterface
{
	function findByField($conditions = []);
	function deleteById($id);
	function create($data);
	function update($id,$data);
	function searchData($conditions = [], $getResult);
}