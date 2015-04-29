<?php

namespace AddressBook\InputFilter;

use Zend\InputFilter\InputFilter;

class SocieteInputFilter extends InputFilter {

    public function __construct() {
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
        
        $input = new \Zend\InputFilter\Input('site_web');

        // Trim du site_web
        $filter = new \Zend\Filter\StringTrim();
        $input->getFilterChain()->attach($filter);

        // Striptags du site_web
        $filter = new \Zend\Filter\StripTags();
        $input->getFilterChain()->attach($filter);

        $validator = new \Zend\Validator\StringLength();
        $validator->setMax(40);
        $input->getValidatorChain()->attach($validator);

        $validator = new \Zend\Validator\NotEmpty();
        $input->getValidatorChain()->attach($validator);

        $this->add($input);
    }

}
