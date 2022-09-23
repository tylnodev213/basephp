<?php
include_once ("mvc/models/BaseModel.php");
class UserTokenModel extends BaseModel {
    public $fillable = [
        'id',
        'email',
        'token',
        'timeModified'
    ];

    public function __construct()
    {
        $this->tableName = 'user_token';
    }

    public function count($email)
    {
        $db = DB::getInstance();
        $sql = $db->prepare("select count(id) as allcount from {$this->tableName} where email=?");
        $sql->execute(array($email));

        return $sql;
    }

    public function create($data): bool
    {

        foreach ($data as $key => $value) {
            if(in_array($key, $this->fillable)) {
                $fields[] = $key;
                $values[] = $value;
            }
        }

        $fields = implode(', ', $fields);
        $db = DB::getInstance();
        $sql = $db->prepare("insert into {$this->tableName}({$fields}) values (?, ?)");

        return $sql->execute($values);

    }

    public function update($email, $token): bool
    {
        $db = DB::getInstance();
        $sql = $db->prepare("update {$this->tableName} set token= ? where email= ?");

        return $sql->execute(array($token, $email));
    }

    public function deleteById($email): bool
    {
        $db = DB::getInstance();
        $sql = $db->prepare("delete from {$this->tableName} where email= ?");

        return $sql->execute(array($email));
    }

    public function findByField($email, $nameField): bool|PDOStatement
    {

        $db = DB::getInstance();

        $sql = $db->prepare("SELECT token FROM {$this->tableName} WHERE {$nameField} = :email");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array('email' => $email));

        return $sql;
    }

}
?>