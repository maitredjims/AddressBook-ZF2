<?php

namespace AddressBook\Service\Contact;

interface ContactServiceInterface 
{
    public function getAll();

    public function getById($id);

    public function getByIdWithSociete($id);

    public function insert(\Zend\Form\Form $form, $dataAssoc);

    public function update($id, \Zend\Form\Form $form, $dataAssoc);

    public function delete($id);
}
