<?php
include_once ("mvc/models/Interface/QueryInterface.php");
include_once ("mvc/helpers/uploadFile.php");
abstract class BaseModel extends DB implements QueryInterface
{
	public $tableName;
	public $fillable;

	public function getAll($fields = [])
	{
		if (empty($fields)) {
			$fields[] = 'id';
		}
		$fields = implode(', ', $fields);
		// TODO: Implement getAll() method.
		$db=DB::getInstance();
		$sql= "select {$fields} from {$this->tableName} where del_flag = " . DELETED_OFF;
        $result=$db->query($sql);
		//$result->setFetchMode(PDO::FETCH_CLASS, 'AdminObject');
		return $result;
	}

	public function create($data)
	{
		// TODO: Implement create() method.
		$avatar = uploadFile();
		$data = array_merge($data, [
			'avatar'=>$avatar,
			'ins_id' => getSessionAdmin('id'),
			'ins_datetime' => date('Y-m-d H:i:s')
		]);
		// check fillable
		foreach ($data as $key => $value) {
			$fields[] = $key;
            $values[] = $value;
		}
		$fields = implode(', ', $fields);
		// run exec insert db;
        $db=DB::getInstance();
        $req=$db->prepare("INSERT INTO {$this->tableName}({$fields}) VALUES(?,?,?,?,?,?,?);");
        $req->execute($values);
	}

	public function update($id, $data)
	{
		// TODO: Implement create() method.
		$avatar = uploadFile();
		$data = array_merge($data, [
			'avatar'=>$avatar,
			'upd_id' => getSessionAdmin('id'),
			'upd_datetime' => date('Y-m-d H:i:s')
		]);
		// check fillable
        foreach ($data as $key => $value) {
			$fields[] = $key."=?";
            $values[] = $value;
		}
		$fields = implode(', ', $fields);
		$values[]=$id;
		// run exec insert db;
        $db=DB::getInstance();
        $req=$db->prepare("UPDATE {$this->tableName} SET {$fields} WHERE id = ?");
        $req->execute($values);
		// check fillable

		// run exec insert db;
	}
	public function deleteById($id)
	{
		$db=DB::getInstance();
        $req=$db->prepare("DELETE FROM {$this->tableName} WHERE id = ?");
        $req->execute($id);
	}
	public function findById($id)
	{
		$db=DB::getInstance();
		$fields = implode(', ', $this->fillable);
        $result=$db->query("SELECT {$fields} FROM {$this->tableName} WHERE id = {$id}");
		return $result;
	}
	public function find($email,$name)
	{
		$db=DB::getInstance();
		$fields = implode(', ', $this->fillable);
        $result=$db->query("SELECT {$fields} FROM {$this->tableName} WHERE name like '%{$name}%' AND email like '%{$email}%' ");
		return $result;
	}
	public function login($email){
		$fields = implode(', ', $this->fillable);
        $sql = "SELECT {$fields} FROM {$this->tableName} WHERE email='$email'";
        return ($this->select($sql)); 
    }
}