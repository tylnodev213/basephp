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

    public function create($data): bool
    {
        // TODO: Implement create() method.
        $data = array_merge($data, [
            'ins_id' => getSessionAdmin('id'),
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
        $req = $db->prepare("INSERT INTO {$this->tableName}({$fields}) VALUES(?,?,?,?,?,?,?);");

        return $req->execute($values);
    }

}
?>