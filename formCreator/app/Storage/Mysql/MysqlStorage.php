<?php

namespace formCreator\app\Storage\Mysql;

use formCreator\app\Storage\AbstractStorage;
use formCreator\app\Storage\Mysql\PDO\PDOConnection;

class MysqlStorage extends AbstractStorage
{
    protected $db;

    public function __construct($db_settings)
    {
        $this->db = PDOConnection::getConnection($db_settings);
    }


    public function getAll()
    {
        $res = $this->db->query("SELECT * FROM `form`");
        return $res->fetch();
    }

    public function getEntityByID($id)
    {

    }

    public function save($entity)
    {
        $this->db->query('INSERT INTO');
    }

    public function delete($entity)
    {

    }



}