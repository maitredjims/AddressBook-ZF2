<?php

namespace AddressBook\InputFilter;

use Zend\InputFilter\InputFilter;

class ContactInputFilter extends InputFilter
{
    public function __construct()
    {
        
        $input = new \Zend\InputFilter\Input('prenom');
        
        // Trim du prénom
        $filter = new \Zend\Filter\StringTrim();
        $input->getFilterChain()->attach($filter);
        
        // Striptags du prénom
        $filter = new \Zend\Filter\StripTags();
        $input->getFilterChain()->attach($filter);
        
        $validator = new \Zend\Validator\StringLength();
        $validator->setMax(40);
        $input->getValidatorChain()->attach($validator);
        
        $validator = new \Zend\Validator\NotEmpty();
        $input->getValidatorChain()->attach($validator);
        
        $this->add($input);
        
        $input = new \Zend\InputFilter\Input('nom');
        
        // Trim du nom
        $filter = new \Zend\Filter\StringTrim();
        $input->getFilterChain()->attach($filter);
        
        // Striptags du nom
        $filter = new \Zend\Filter\StripTags();
        $input->getFilterChain()->attach($filter);
        
        $validator = new \Zend\Validator\StringLength();
        $validator->setMax(40);
        $input->getValidatorChain()->attach($validator);
        
        $validator = new \Zend\Validator\NotEmpty();
        $input->getValidatorChain()->attach($validator);
        
        $this->add($input);
        
        $input = new \Zend\InputFilter\Input('email');
        $input->setRequired(false);
        // Trim du email
        $filter = new \Zend\Filter\StringTrim();
        $input->getFilterChain()->attach($filter);
        
        // Striptags du email
        $filter = new \Zend\Filter\StripTags();
        $input->getFilterChain()->attach($filter);
        
        $validator = new \Zend\Validator\EmailAddress();
        $input->getValidatorChain()->attach($validator);
        
        $this->add($input);
        
        $input = new \Zend\InputFilter\Input('telephone');
        $input->setRequired(false);
        // Trim du téléphone
        $filter = new \Zend\Filter\StringTrim();
        $input->getFilterChain()->attach($filter);
        
        // Striptags du téléphone
        $filter = new \Zend\Filter\StripTags();
        $input->getFilterChain()->attach($filter);
        
        $validator = new \Zend\Validator\StringLength();
        $validator->setMax(20);
        $input->getValidatorChain()->attach($validator);
        
        $this->add($input);
    }
}
