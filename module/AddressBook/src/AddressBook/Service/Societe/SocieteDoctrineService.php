<?php

namespace AddressBook\Service\Societe;

use AddressBook\Entity\Societe;
use AddressBook\InputFilter\SocieteInputFilter;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

class SocieteDoctrineService implements SocieteServiceInterface
{
    /**
     *
     * @var EntityManager
     */
    protected $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function getAll() {
        $repo = $this->em->getRepository('AddressBook\Entity\Societe');

        return $repo->findAll();
    }

    public function getById($id) {
        $repo = $this->em->getRepository('AddressBook\Entity\Societe');

        return $repo->find($id);
    }

    public function insert(\Zend\Form\Form $form, $dataAssoc) {
        $societe = new Societe();

        $hydrator = new DoctrineObject($this->em);
        $form->setHydrator($hydrator);

        $form->bind($societe);
        $form->setInputFilter(new SocieteInputFilter());
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            return null;
        }
        
        $this->em->persist($societe);
        $this->em->flush();
        
        return $societe;
    }

    public function update($id, \Zend\Form\Form $form, $dataAssoc) {
        
    }
    
    public function delete($id) {
        
    }

}
