<?php
include_once ("mvc/models/BaseModel.php");
class UserModel extends BaseModel{
    public $fillable = [
        'id',
        'facebook_id',
        'name',
        'avatar',
        'email',
        'password',
        'ins_id',
        'ins_datetime',
        'upd_id',
        'upd_datetime',
        'status',
        'del_flag'
    ];

	public function __construct()
	{
		$this->tableName = 'users';
	}

}
?>