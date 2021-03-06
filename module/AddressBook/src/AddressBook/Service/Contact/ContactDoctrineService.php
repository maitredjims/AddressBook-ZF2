<?php

namespace AddressBook\Service\Contact;

use AddressBook\Entity\Contact;
use AddressBook\InputFilter\ContactInputFilter;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

class ContactDoctrineService implements ContactServiceInterface {

    /**
     *
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function getAll() {
        $repo = $this->em->getRepository('AddressBook\Entity\Contact');

        return $repo->findAll();
    }

    public function getById($id, $form = null) {
        $repo = $this->em->getRepository('AddressBook\Entity\Contact');
        
        $repoFind = $repo->find($id);

        if ($form != null) {
            $hydrator = new DoctrineObject($this->em);
            $form->setHydrator($hydrator);
            $form->bind($repoFind);
        }

        return $repoFind;
        
    }

    public function getByIdWithSociete($id) {
        $dql = "SELECT c, s "
                . "FROM AddressBook\Entity\Contact c "
                . "LEFT JOIN c.societe s "
                . "WHERE c.id = :id ";

        return $this->em->createQuery($dql)
                        ->setParameter('id', $id)
                        ->getSingleResult();
    }

    public function insert(\Zend\Form\Form $form, $dataAssoc) {
        $contact = new Contact();

        $hydrator = new DoctrineObject($this->em);
        $form->setHydrator($hydrator);

        $form->bind($contact);
        $form->setInputFilter(new ContactInputFilter());
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            return null;
        }
        
        $this->em->persist($contact);
        $this->em->flush();
        
        return $contact;
    }
    
    public function update($contact, \Zend\Form\Form $form, $dataAssoc) {
        //$contact = $this->em->find('AddressBook\Entity\Contact', $id);
        
        $hydrator = new DoctrineObject($this->em);
        
        $form->setHydrator($hydrator);
        $form->bind($contact);
        $form->setInputFilter(new ContactInputFilter());
        $form->setData($dataAssoc);
        
        if (!$form->isValid()) {
            return null;
        }     
        
        $this->em->persist($contact);
        $this->em->flush();
        
        return $contact;
    }
    
    public function delete($id) {
        $contact = $this->em->find('AddressBook\Entity\Contact', $id);
        
        $this->em->remove($contact);
        $this->em->flush();
        
        return $contact;
    }
} 