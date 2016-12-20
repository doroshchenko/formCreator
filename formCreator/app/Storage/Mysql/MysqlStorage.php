<?php

namespace formCreator\app\Storage\Mysql;

use formCreator\app\Storage\AbstractStorage;
use formCreator\app\Storage\Mysql\PDO\PDOConnection;

class MysqlStorage extends AbstractStorage
{
    protected $db;

    /**
     * results of sql operations
     * (true|false)
     * @var array()
     */
    protected $transaction_has_errors = array();

    public function __construct($db_settings)
    {
        $this->db = PDOConnection::getConnection($db_settings);
    }

    public function getAllForms()
    {
        $res = $this->db->query("SELECT * FROM `form`");
        $forms = $res->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($forms as &$form) {
            $form['elements'] = $this->db->query('SELECT * FROM `form_element`
                WHERE id_form ='.$form['id_form'])->fetchAll(\PDO::FETCH_ASSOC);
            foreach( $form['elements'] as &$element) {
                $element['values'] = $this->db->query('SELECT * FROM `form_element_value`
                    WHERE id_form_element ='.$element['id_form_element'])->fetchAll(\PDO::FETCH_ASSOC);
            }
        }

        return ($forms) ? $forms : array();
    }

    public function save($data)
    {
        $this->db->beginTransaction();
        $this->saveForm($data);
        $this->saveFormElements($data);
        if (!in_array(true, $this->transaction_has_errors)) {
            $this->db->commit();
        }
    }

    public function delete($entity)
    {
        $stmt = $this->db->prepare('DELETE FROM `form` WHERE id_form=?');
        $res = $stmt->execute(array($entity['id_form']));
    }

    public function formExists($id)
    {
        $stmt = $this->db->prepare('SELECT * from `form` WHERE id_form=?');
        $stmt->execute(array($id));
        $res = $stmt->fetchAll();
        return $res;
    }

    protected function saveForm($data)
    {
        if ($this->formExists($data['id_form'])) {
            $stmt = $this->db->prepare('INSERT INTO  `form` VALUES(?,?,?,?,?)
                ON DUPLICATE KEY UPDATE name =VALUES(name), action=VALUES(action),
                                        enctype=VALUES(enctype), method=VALUES(method)');
            $this->transaction_has_errors[] = !$stmt->execute(
                array($data['id_form'],
                      $data['name'],
                      $data['action'],
                      $data['enctype'],
                      $data['method'])
            );
            $stmt = $this->db->prepare('DELETE FROM `form_element` WHERE id_form=?');
            $this->transaction_has_errors[] = !$stmt->execute(array($data['id_form']));
        } else {
            $stmt = $this->db->prepare('INSERT INTO `form` VALUES (null,?,?,?,?)');
            $this->transaction_has_errors[] = !$stmt->execute(
                array($data['name'],
                      $data['action'],
                      $data['enctype'],
                      $data['method'])
            );
        }
    }

    protected function saveFormElements($data)
    {
        foreach ($data['elements'] as $element) {
            $formId = $element['id_form']
                ? $element['id_form']
                : $this->db->lastInsertId();
            $stmt = $this->db->prepare('INSERT INTO `form_element` VALUES(null,?,?,?,?)');
            $this->transaction_has_errors[] = !$stmt->execute(array($formId,
                $element['name'],
                $element['label'],
                $element['type']));
            $elementId = $this->db->lastInsertId();
            foreach ($element['values'] as $value) {
                $stmt = $this->db->prepare('INSERT INTO `form_element_value` VALUES(?,?)');
                $this->transaction_has_errors[] = !$stmt->execute(array($elementId,
                    $value));
            }

        }
    }

    public function getFormByName($name)
    {
        $stmt = $this->db->prepare("SELECT * FROM `form` WHERE name =?");
        $stmt->execute(array($name));
        $forms = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($forms as &$form) {
            $form['elements'] = $this->db->query('SELECT * FROM `form_element`
                WHERE id_form ='.$form['id_form'])->fetchAll(\PDO::FETCH_ASSOC);
            foreach( $form['elements'] as &$element) {
                $element['values'] = $this->db->query('SELECT * FROM `form_element_value`
                    WHERE id_form_element ='.$element['id_form_element'])->fetchAll(\PDO::FETCH_ASSOC);
            }
        }
        return ($forms) ? $forms : array();

    }

    public function getData($mode, $name = null)
    {
        switch ($mode) {
            case '*' :
                return $this->getAllForms();
                break;
            case 'name' :
                return $this->getFormByName($name);
                break;

        }
    }
}

