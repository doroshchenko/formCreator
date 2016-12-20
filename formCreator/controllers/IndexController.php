<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 13.11.16
 * Time: 12.30
 */

namespace formCreator\controllers;

use formCreator\controllers\Controller;
use formCreator\app\View;
use formCreator\entities\Form;

class IndexController extends Controller
{
    public function indexAction()
    {
        $view = View::create('index', array());
        return $view;
    }

    public function usageAction($name)
    {
        $form = new Form();
        $form->setStorage($this->getStorage());
        $data['form'] = $form->getFormByName($name)[0];
        $view = View::create('usage', $data);
        return $view;
    }
}