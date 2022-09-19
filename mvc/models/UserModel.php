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

    public function create($data): bool
    {
        // TODO: Implement create() method.
        $data = array_merge($data, [
            'ins_datetime' => date('Y-m-d H:i:s')
        ]);

        $fields = [];
        $values = [];
        foreach ($data as $key => $value) {
            // check fillable
            if (in_array($key, $this->fillable)) {
                $fields[] = $key;
                $values[] = $value;
            }
        }
        $fields = implode(', ', $fields);

        // run exec insert db;
        $db = DB::getInstance();
        $req = $db->prepare("INSERT INTO {$this->tableName}({$fields}) VALUES(?,?,?,?,?);");

        return $req->execute($values);
    }

}
?>