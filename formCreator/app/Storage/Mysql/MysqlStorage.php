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
            foreach( $form['elements'] as &$element) {
                $element['values'] = $this->db->query('SELECT * FROM `form_element_value`
                    WHERE id_form_element ='.$element['id_form_element'])->fetchAll(\PDO::FETCH_ASSOC);
            }
        }

        return ($forms) ? $forms : array();
    }

    public function getEntityByID($id)
    {

    }

    public function save($data)
    {
        if (!$this->entityExists($data['name'])) {
            $this->db->beginTransaction();
            $stmt = $this->db->prepare('INSERT INTO `form` VALUES (null,?,?,?,?)');
            $res = $stmt->execute(array($data['name'],
                                        $data['action'],
                                        $data['enctype'],
                                        $data['method']));
            if ($res) {
                $formId = $this->db->lastInsertId();
                foreach ($data['elements'] as $element) {
                    $stmt = $this->db->prepare('INSERT INTO `form_element` VALUES(null,?,?,?,?)');
                    $res = $stmt->execute(array($formId,
                                                $element['name'],
                                                $element['label'],
                                                $element['type']));

                }
                $this->db->commit();
            }
        } else {
            //$this->db->query();
        }
    }

    public function delete($entity)
    {

    }

    public function entityExists($name)
    {
        $stmt = $this->db->prepare('SELECT * from `form` WHERE name=?');
        $stmt->execute(array($name));
        $res = $stmt->fetchAll();

        return $res;
    }

}