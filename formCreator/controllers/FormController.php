<?php

namespace formCreator\controllers;

use formCreator\entities\Form;
use formCreator\entities\FormElement;

class FormController extends Controller
{
    public function indexAction()
    {
        $form = new Form();
        $form->setStorage($this->getStorage());
        $forms = $form->getAll();
        return $forms;

    }

    public function saveAction($params)
    {
        $formName = $params['form'];
        $formMethod = $params['form_method'];
        $formElements = $params['form']['elements'];
        try {
            $form = new Form();
            $form->setStorage($this->getStorage())
                ->setName($formName)
                ->setMethod($formMethod)
                ->setElements($formElements)
                ->save();
            $res = $form->getAll();
            $t = 5;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
