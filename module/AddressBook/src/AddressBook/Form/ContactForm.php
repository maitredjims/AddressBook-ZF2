<?php

namespace AddressBook\Form;

use Zend\Form\Element\Text;
use Zend\Form\Form;

use Doctrine\ORM\EntityManager;

class ContactForm extends Form
{
    protected $entityManager;
    
    public function __construct(EntityManager $entityManager) {
        parent::__construct('contact');
        
        $this->entityManager = $entityManager;
        
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
       
//        $element = new \Zend\Form\Element\Select('societe');
//        $element->setLabel('Société du contact :');
//        $element->setDisableInArrayValidator(true);
//        $this->add($element);
        
        $element = new \DoctrineModule\Form\Element\ObjectSelect('societe');
        $element->setDisableInArrayValidator(true);
        $element->setOptions(array(
            'object_manager'     => $this->entityManager,
            'label' => 'Société du contact :',
            'target_class' => 'AddressBook\Entity\Societe',
            // Property => nom du champ qu'on souhaite, ici le nom des sociétés qu'on souhaite rajouter au Select
            'property' => 'nom',
            'is_method' => true,
            'find_method' => array(
                'name' => 'getSociete',
            ),
        ));
        $this->add($element);
    }
}
