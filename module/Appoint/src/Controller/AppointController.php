<?php

namespace Appoint\Controller;

use Appoint\Form\AppointForm;
use Appoint\Model\Appoint;
use Appoint\Model\AppointTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AppointController extends AbstractActionController
{
    // Pass in an appointment table
    public function __construct(AppointTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'appoints' => $this->table->fetchAll(),
        ]);
    }

    /* Add appointment to the form: */
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
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('appoint', ['action' => 'add']);
        }

        // Retrieve the appointment with the specified id. Doing so raises
        // an exception if the appointment is not found, which should result
        // in redirecting to the landing page.
        try {
            $appoint = $this->table->getAppoint($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('appoint', ['action' => 'index']);
        }

        $form = new AppointForm();
        $form->bind($appoint);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($appoint->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveAppoint($appoint);

        // Redirect to appointment list
        return $this->redirect()->toRoute('appoint', ['action' => 'index']);
    }

    public function deleteAction()
    {
        #To do: ddd delete functionality
    }
}