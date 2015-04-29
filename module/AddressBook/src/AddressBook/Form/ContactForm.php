<?php

namespace AddressBook\Form;

use Zend\Form\Element\Text;
use Zend\Form\Form;

class ContactForm extends Form
{
    public function __construct() {
        parent::__construct('contact');
        
        // Gestion de l'arrayCopy
        $this->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods());
        
        $element = new Text('prenom');
        $element->setLabel('Prénom : ');        
        $this->add($element);
        
        $element = new Text('nom');
        $element->setLabel('Nom : ');        
        $this->add($element);
        
        $element = new Text('email');
        $element->setLabel('Email : ');        
        $this->add($element);
        
        $element = new Text('telephone');
        $element->setLabel('Téléphone : ');        
        $this->add($element);
       
        $element = new \Zend\Form\Element\Select('societe');
        $element->setLabel('Société du contact :');
        $element->setDisableInArrayValidator(true);
        $this->add($element);
    }
}
