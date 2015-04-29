<?php

namespace AddressBook\Service\Societe;

interface SocieteServiceInterface 
{
   public function getAll();
   
   public function getById($id);
   
   public function insert(\Zend\Form\Form $form, $dataAssoc);
   
   public function update($id, \Zend\Form\Form $form, $dataAssoc);
   
   public function delete($id);
}
