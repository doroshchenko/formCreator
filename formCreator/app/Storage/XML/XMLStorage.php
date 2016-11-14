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
        $xml_file_path = dirname(__FILE__, 4);
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
    }

    public function delete($entity)
    {

    }

    public function getAll()
    {

    }

    public function saveForm($data)
    {
        if (!$this->formExists($data['id_form'])) {
            unset($data['storage']);
            $formId = $this->xml->form->count();
            $form = $this->xml->addChild('form');
            $form->addChild('id_form', $formId);
            foreach ($data as $prop => $value) {
                if ($prop == 'elements') {
                        $this->saveFormElements($value, $form);
                } else {
                    $form->addChild($prop, $value);
                }
            }
            $this->xml->asXML($this->xml_file);
        }
    }

    public function saveFormElements($elementsData, $formNode)
    {
        $elementsNode = $formNode->addChild('elements');
        foreach ($elementsData as $elementData) {
            $elementNode = $elementsNode->addChild('element');
            foreach ($elementData as $elementPropName => $elementPropValue) {
                if ($elementPropName != 'values') {
                    $elementNode->addChild($elementPropName, $elementPropValue);
                } else {
                    $elementValuesNode = $elementNode->addChild('values');
                    $values = &$elementPropValue;
                    foreach ($values as $name => $value) {
                        $elementValuesNode->addChild($name, $value);
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
}