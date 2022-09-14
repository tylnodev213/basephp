<?php
include_once ("mvc/models/BaseModel.php");

class AdminModel extends BaseModel{
    public $fillable = [
		'id',
		'name',
        'avatar',
        'email',
        'password',
        'ins_id',
        'ins_datetime',
        'upd_id',
        'upd_datetime',
        'role_type',
        'del_flag'
	];

	public function __construct()
	{
		$this->tableName = 'admin';
	}

}
?>