<?php

namespace Appoint\Controller;
use Appoint\Form\AppointForm;
use Appoint\Model\Appoint;

use Appoint\Model\AppointTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AppointController extends AbstractActionController
{
    // Add this constructor:
    public function __construct(AppointTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        #return new ViewModel()
        #die('INDEX');
        return new ViewModel([
            'appoints' => $this->table->fetchAll(),
        ]);
    }

    /* Update the following method to read as follows: */
    public function addAction()
    {
        $form = new AppointForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $appoint = new Appoint();
        $form->setInputFilter($appoint->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $appoint->exchangeArray($form->getData());
        $this->table->saveAppoint($appoint);
        return $this->redirect()->toRoute('appoint');
    }

    public function editAction()
    {
        #return new ViewModel()
    }

    public function deleteAction()
    {
        #return new ViewModel()
    }
}