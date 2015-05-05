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

    public function getById($id, $form = null) {
        $repo = $this->em->getRepository('AddressBook\Entity\Societe');
        
        $repoFind = $repo->find($id);

        if ($form != null) {
            $hydrator = new DoctrineObject($this->em);
            $form->setHydrator($hydrator);
            $form->bind($repoFind);
        }

        return $repoFind;
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

    public function update($societe, \Zend\Form\Form $form, $dataAssoc) {
        //$societe = $this->em->find('AddressBook\Entity\Societe', $id);
        
        $hydrator = new DoctrineObject($this->em);
        
        $form->setHydrator($hydrator);
        $form->bind($societe);
        $form->setInputFilter(new SocieteInputFilter());
        $form->setData($dataAssoc);
        
        if(!$form->isValid()) {
            return null;
        }
        
        $this->em->persist($societe);
        $this->em->flush();
        
        return $societe;
    }
    
    public function delete($id) {
        $societe = $this->em->find('AddressBook\Entity\Societe', $id);
        
        $this->em->remove($societe);
        $this->em->flush();
        
        return $societe;
    }

}
