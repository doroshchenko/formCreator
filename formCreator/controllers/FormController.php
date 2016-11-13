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
        if (!isset($params['save'])) {
            return null;
        }
        foreach ($params['form'] as $formData) {
            $formId = $formData['id_form'];
            $formName = isset($formData['name']) ? $formData['name'] :  null;
            $formAction = isset($formData['action']) ? $formData['action'] : null;
            $formMethod = isset($formData['method']) ? $formData['method'] : null;
            $formEnctype = isset($formData['enctype']) ? $formData['enctype'] : null;
            $formElements = isset($formData['elements']) ? $formData['elements'] : array();
            try {
                $form = new Form($formId);
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
        }

        return $this->redirect('form/index');
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

    public function deleteAction($params)
    {
        if (isset($params['delete']) && isset($params['form'])) {
            foreach ($params['form'] as $form) {
                try {
                    $form = new Form($form['id_form']);
                    $form->setStorage($this->getStorage());
                    $form->delete();
                } catch(\Exception $e) {
                    return $e->getMessage();
                }
            }

            return $this->redirect('form/index');
        }
    }
}
