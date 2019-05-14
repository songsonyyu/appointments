<?php

namespace Appoint\Form;

use Zend\Form\Form;

class AppointForm extends Form
{
    public function __construct($name = null)
    {
        // zend-form manages the various form inputs 
        parent::__construct('appoint');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'patientName',
            'type' => 'text',
            'options' => [
                'label' => 'patientName',
            ],
        ]);
        $this->add([
            'name' => 'reason',
            'type' => 'text',
            'options' => [
                'label' => 'reason',
            ],
        ]);
        $this->add([
            'name' => 'startTime',
            'type' => 'text',
            'options' => [
                'label' => 'startTime',
            ],
        ]);
        $this->add([
            'name' => 'endTime',
            'type' => 'text',
            'options' => [
                'label' => 'endTime',
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}