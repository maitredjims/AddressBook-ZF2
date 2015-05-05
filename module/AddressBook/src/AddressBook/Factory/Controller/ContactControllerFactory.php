<?php

namespace AddressBook\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use AddressBook\Controller\ContactController;

class ContactControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /**
         * @var $serviceLocator \Zend\Mvc\Controller\ControllerManager
         */
        $service = $serviceLocator->getServiceLocator();
        
        $contactForm = $service->get('FormElementManager')->get('AddressBook\Form\ContactForm');
        
        $em = $service->get('Doctrine\ORM\EntityManager');
        
        $contactService = new \AddressBook\Service\Contact\ContactDoctrineService($em);
        $societeService = new \AddressBook\Service\Societe\SocieteDoctrineService($em);
        
        $controller = new ContactController($contactForm, $contactService, $societeService);
        
        return $controller;
    }
}
