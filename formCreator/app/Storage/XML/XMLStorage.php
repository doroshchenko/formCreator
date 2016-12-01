<?php

namespace formCreator\app\Storage\XML;

use formCreator\app\Storage\AbstractStorage;
use \DOMDocument;
use \SimpleXMLElement;

class XMLStorage extends AbstractStorage
{
    /**
     * xml object
     * @var SimpleXMLElement
     */
    private $xml;

    /**
     * xml file
     * @var
     */
    private $xml_file;

    public function __construct($settings)
    {
        if (!isset($settings['file'])) {
            throw new \Exception ('you must specify xml storage file in configuration');
        }
        $xml_file_path = dirname(__FILE__);
        $xml_file = $xml_file_path . DIRECTORY_SEPARATOR . $settings['file'];
        if (!file_exists($xml_file)) {
            $old = umask(0);
            $xml = new DOMDocument('1.0', 'utf-8');
            $element = $xml->createElement('forms');
            $xml->appendChild($element);
            $xml->save($xml_file);
            chmod($xml_file, 0777);
            umask($old);
        }
        $this->xml_file = $xml_file;
        $this->xml = simplexml_load_file($xml_file);
    }
    public function getAllEntities()
    {

    }

    public function save($data)
    {
        $this->saveForm($data);
        $this->formatXMLFile();
    }

    public function delete($entity)
    {
        $forms = $this->xml->xpath('/forms/form');
        if (count($forms) == 1) {
            unset($this->xml->form[0]);
            $this->xml->addChild('forms');
        } else {
            $form = $this->xml->xpath('/forms/form[id_form='.$entity['id_form'].']')[0];
            unset($form[0]);
        }

        $this->xml->asXML($this->xml_file);
        $this->formatXMLFile();
    }

    public function getData($mode, $name = null)
    {
        switch ($mode) {
            case '*' :
                $data = json_decode(json_encode((array) $this->xml), true);
                return $this->getAll($data);
                break;
            case 'name' :
                $form = $this->xml->xpath('/forms/form[name="'.$name.'"]');
                if ($form) {
                    $data['form'] = json_decode(json_encode((array) $form[0]), true);
                    return $this->getAll($data);
                } else {
                    return null;
                }
        }
    }

    public function getAll($data)
    {
        if (isset($data['form']) && count($data['form'])) {
            if (!isset($data['form'][0])){
                $arr = $data['form'];
                unset($data);
                $data['form'][0] = $arr;
                unset($arr);
            }
            foreach ($data['form'] as &$form) {
                if (isset($form['elements']['element']) && !isset($form['elements']['element'][0])) {
                    $arr = $form['elements']['element'];
                    unset($form['elements']['element']);
                    $form['elements']['element'][0] = $arr;
                    unset($arr);
                }
                if (isset($form['elements']['element'])) {
                    foreach ($form['elements']['element'] as $element) {
                        $form['elements'][] = $element;
                        if (isset($element['values'])) {
                            foreach ($element['values'] as $value) {
                                $element['values'][] = $value;
                            }
                            unset($element['values']['value']);
                        }
                    }
                    unset($form['elements']['element']);
                }
                $data[] = $form;
            }
            unset($data['form']);
        }

        return $data;
    }

    public function saveForm($data)
    {
        if (!$this->formExists($data['id_form'])) {
            $formId = $this->xml->form->count();
            $form = $this->xml->addChild('form');
            $form->addChild('id_form', $formId);
            $form->addChild('name', $data['name']);
            $form->addChild('action', $data['action']);
            $form->addChild('enctype', $data['enctype']);
            $form->addChild('method', $data['method']);
            $this->saveFormElements($data['elements'], $form);
            $this->xml->asXML($this->xml_file);
        } else {
            $form = $this->xml->xpath('/forms/form[id_form='.$data['id_form'].']')[0];
            unset($form->elements);
            $form->id_form = $data['id_form'];
            $form->name = $data['name'];
            $form->action = $data['action'];
            $form->enctype = $data['enctype'];
            $form->method = $data['method'];
            $this->saveFormElements($data['elements'], $form);
            $this->xml->asXML($this->xml_file);
        }
    }

    public function saveFormElements($elementsData, $formNode)
    {
        $elementsNode = $formNode->addChild('elements');
        foreach ($elementsData as $elementData) {
            $elementData['id_form'] = $formNode->id_form[0];
            $elementNode = $elementsNode->addChild('element');
            foreach ($elementData as $elementPropName => $elementPropValue) {
                if ($elementPropName != 'values') {
                    $elementNode->addChild($elementPropName, $elementPropValue);
                } else {
                    $elementValuesNode = $elementNode->addChild('values');
                    $values = &$elementPropValue;
                    foreach ($values as $name => $value) {
                        $elementValuesNode->addChild('v_'.$name, $value);
                    }
                }
            }
        }
    }

    public function formExists($id_form)
    {
        foreach ($this->xml->form as $form) {
            if ($form->id_form == $id_form) {
                return true;
            }
        }
        return false;
    }

    protected function formatXMLFile()
    {
        $dom = new DOMDocument("1.0");
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($this->xml->asXML());
        $dom->saveXML();
        $dom->save($this->xml_file);
    }
}