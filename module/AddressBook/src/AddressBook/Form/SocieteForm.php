<?php

namespace AddressBook\Form;

use Zend\Form\Form;
use Zend\Form\Element\Text;

class SocieteForm extends Form
{
    public function __construct() {
        parent::__construct('societe');
        
        $element = new Text('nom');
        $element->setLabel('Nom de la société : ');        
        $this->add($element);
        
        $element = new Text('siteWeb');
        $element->setLabel('Site web de la société : ');        
        $this->add($element);
    }

}
