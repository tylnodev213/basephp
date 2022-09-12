<?php
include_once ("mvc/models/BaseModel.php");
class AdminObject
{
    public $id;
    public $name;
    public $password;
    public $email;
    public $avatar;
    public $role_type;
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
        $this->role_type = $row['role_type'];
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
        'role_type',
		'del_flag',
		'ins_id',
		'ins_datetime',
		'upd_id',
		'upd_datetime'
	];

	public function __construct()
	{
		$this->tableName = 'admin';
	}

}
?>