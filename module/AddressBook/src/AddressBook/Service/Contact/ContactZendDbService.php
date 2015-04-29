<?php

namespace AddressBook\Service\Contact;

use Zend\Db\TableGateway\AbstractTableGateway;

class ContactZendDbService implements ContactServiceInterface
{
    protected $tableGateway;
    
    public function __construct(AbstractTableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function getAll() 
    {
        $listeContactsAssoc = $this->tableGateway->select()->toArray();
        $listeContacts = array();
        
        foreach ($listeContactsAssoc as $contactAssoc) {
            $contact = new \AddressBook\Entity\Contact();
            
            // Objet qui converti un Objet en tableau ou un tableau en Objet.
            $hydrator = new \Zend\Stdlib\Hydrator\ClassMethods();  
            // Hydrate convertit un tableau en Objet. Extract convertit un Objet en tableau.
            $hydrator->hydrate($contactAssoc, $contact);
            
            $listeContacts[] = $contact;
        }
        
        return $listeContacts;
    }

    public function getById($id) 
    {
        //throw new \Exception('Méthode pas encore implémentée');
        $contactAssoc = (array) $this->tableGateway->select(array('id' => $id))->current();
        
        if(!$contactAssoc){
            return null;
        }
        
        $contact = new \AddressBook\Entity\Contact();
        $hydrator = new \Zend\Stdlib\Hydrator\ClassMethods();
        $hydrator->hydrate($contactAssoc, $contact);
        
        return $contact;
    }

    public function getByIdWithSociete($id) 
    {
        
    }

    public function insert(\Zend\Form\Form $form, $dataAssoc) {
        throw new Exception ('Pas encore implémenté');
    }

}
