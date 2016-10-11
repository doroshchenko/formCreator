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
        $forms = $res->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($forms as &$form) {
            $form['elements'] = $this->db->query('SELECT * FROM `form_element` WHERE id_form ='.$form['id_form'])
                ->fetchAll(\PDO::FETCH_ASSOC);
        }

        return ($forms) ? $forms : array();
    }

    public function getEntityByID($id)
    {

    }

    public function save($data)
    {
        if (!$this->formExists($data['name'])) {
            $this->db->query('INSERT INTO');
        } else {
            $this->db->query();
        }
    }

    public function delete($entity)
    {

    }

    public function formExists($name)
    {
        $stmt = $this->db->prepare('SELECT * from `form` WHERE name=?');
        $stmt->execute(array($name));
        $res = $stmt->fetchAll();
        return $res;


    }

}