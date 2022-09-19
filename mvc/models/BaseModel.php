<?php
include_once("mvc/models/Interface/QueryInterface.php");

abstract class BaseModel extends DB implements QueryInterface
{

    public $tableName;
    public $fillable;

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

    public function update($id, $data): bool
    {
        // TODO: Implement create() method.
        $data = array_merge($data, [
            'upd_id' => getSessionAdmin('id'),
            'upd_datetime' => date('Y-m-d H:i:s')
        ]);

        $fields = [];
        $values = [];
        foreach ($data as $key => $value) {
            // check fillable
            if (in_array($key, $this->fillable)) {
                $fields[] = $key . "=?";
                $values[] = $value;
            }
        }
        $fields = implode(', ', $fields);
        // insert id at the end array
        $values[] = $id;
        // run exec update db;
        $db = DB::getInstance();
        $req = $db->prepare("UPDATE {$this->tableName} SET {$fields} WHERE id = ?");

        return $req->execute($values);
    }

    public function deleteById($id): bool
    {
        $db = DB::getInstance();

        $sql = $db->prepare("DELETE FROM {$this->tableName} WHERE id = ? AND del_flag = " . DELETED_ON);

        return $sql->execute([$id]);
    }

    public function findById($id, $nameField): bool|PDOStatement
    {
        $fieldSellect = $this->fillable;
        $fieldSellect = array_diff($fieldSellect, ['ins_id', 'ins_datetime', 'upd_id', 'upd_datetime']);
        $fields = implode(', ', $fieldSellect);

        $db = DB::getInstance();

        $sql = $db->prepare("SELECT {$fields} FROM {$this->tableName} WHERE {$nameField} = :id  AND del_flag=".DELETED_OFF);
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array('id' => $id));

        return $sql;
    }

    public function searchData($conditions = [], $getResult): bool|PDOStatement
    {
        //sort
        $sortField = $_GET['sortField'] ?? 'id';
        $sortDirection = $_GET['sortDirection'] ?? 'asc';


        //pagination
        $page = $_GET['page'] ?? 1;
        $pageStart = ($page - 1) * NUMBER_RECORD_EACH_PAGE;

        //condition
        $where['del_flag'] = " = " . DELETED_OFF;

        if (!empty($conditions['name'])) {
            $where['name'] = "like '%" . $conditions['name'] . "%'";
        }
        if (!empty($conditions['email'])) {
            $where['email'] = "like '%" . $conditions['email'] . "%'";
        }
        foreach ($where as $key => $value) {
            $sql[] = $key . " " . $value;
        }
        $where = implode(' AND ', $sql);
        $fieldSellect = $this->fillable;
        $fieldSellect = array_diff($fieldSellect, ['ins_id', 'ins_datetime', 'upd_id', 'upd_datetime', 'del_flag']);
        $fields = implode(', ', $fieldSellect);

        $db = DB::getInstance();
        if($getResult=="getTotalRecord") {
            return $db->query("SELECT COUNT(id) FROM {$this->tableName} WHERE {$where} AND del_flag = " . DELETED_OFF);
        }
        return $db->query("SELECT {$fields} FROM {$this->tableName} WHERE {$where} AND del_flag = " . DELETED_OFF . " ORDER BY {$sortField} {$sortDirection} LIMIT " . NUMBER_RECORD_EACH_PAGE . " OFFSET " . $pageStart);
    }

    public function checkLogin($email, $password): bool|PDOStatement
    {

        $db = DB::getInstance();

        $sql = $db->prepare("SELECT id FROM {$this->tableName} WHERE email = :email AND password = :password AND del_flag = " . DELETED_OFF);
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array(
            'email' => $email,
            'password' => $password
        ));

        return $sql;
    }

}