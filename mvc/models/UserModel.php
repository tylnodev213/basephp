<?php
include_once ("mvc/models/BaseModel.php");
class UserObject
{
    public $id;
    public $name;
    public $password;
    public $email;
    public $avatar;
    public $status;
    public $ins_id;
    public $upd_id;
    public $ins_datetime;
    public $upd_datetime;
    public $del_flag;

    public function __construct($row)
    {
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->email = $row['email'];
        $this->avatar = $row['avatar'];
        $this->status = $row['status'];
        $this->del_flag = $row['del_flag'];
    }
}
class AdminModel extends BaseModel{
    public $fillable = [
		'id',
		'name',
        'avatar',
        'email',
        'password',
        'status',
		'del_flag',
		'ins_id',
		'ins_datetime',
		'upd_id',
		'upd_datetime'
	];

	public function __construct()
	{
		$this->tableName = 'users';
	}

}
?>