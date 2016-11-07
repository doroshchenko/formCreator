<?php

namespace formCreator\controllers;

use formCreator\entities\Form;
use formCreator\entities\FormElement;
use formCreator\app\View;

class FormController extends Controller
{
    public function indexAction()
    {
        $form = new Form();
        $form->setStorage($this->getStorage());
        $forms = $form->getAll();
        $data['forms'] = $forms;

        return View::create('forms', $data);

    }

    public function saveAction($params)
    {
        /*$formName = $params['form'];
        $formMethod = $params['form_method'];
        $formElements = $params['form']['elements'];
        */
        // -- test data -- //
        $formName = '111';
        $formMethod = '222';
        $type = 555;
        $formElements = array(
            array(
                'name' => '111',
                'type' => '222',
                'value' => 333
            ),
            array(
                'name' => '1211',
                'type' => '2222',
                'value' => 3233
            )
        );

        try {
            $form = new Form();
            $form->setStorage($this->getStorage())
                ->setName($formName)
                ->setMethod($formMethod)
                ->setType($type)
                ->setElements($formElements)
                ->save();
            $res = $form->getAll();
            $t = 5;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function addAction($params)
    {
        if (!isset($params['form'])) {
            throw new \Exception('invalid params for adding form');
        }
        $formData = $params['form']['new'];
        $formName = isset($formData['name']) ? $formData['name'] :  null;
        $formAction = isset($formData['action']) ? $formData['action'] : null;
        $formMethod = isset($formData['method']) ? $formData['method'] : null;
        $formEnctype = isset($formData['enctype']) ? $formData['enctype'] : null;
        $formElements = isset($formData['elements']) ? $formData['elements'] : array();
        try {
            $form = new Form();
            $form->setStorage($this->getStorage())
                ->setName($formName)
                ->setMethod($formMethod)
                ->setEnctype($formEnctype)
                ->setAction($formAction)
                ->setElements($formElements);
            $form->save();
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return $this->redirect('form/index');

    }
}
