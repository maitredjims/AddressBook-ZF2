<?php

namespace AddressBook\Controller;

use AddressBook\Form\ContactForm;
use AddressBook\InputFilter\ContactInputFilter;
use AddressBook\Service\Contact\ContactServiceInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ContactController extends AbstractActionController
{
//    protected function getContactService() {
//        $service = new \AddressBook\Service\Contact\ContactFakeService();
//        
//        return $service;
//    }
    
//    protected function getContactService() {
//        //$factory = new \Zend\Db\Adapter\AdapterServiceFactory();
//        //$adapter = $factory->createService($this->getServiceLocator());
//        
//        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//        $tableGateway = new \Zend\Db\TableGateway\TableGateway('contact', $adapter);
//        $service = new \AddressBook\Service\Contact\ContactZendDbService($tableGateway);
//        
//        return $service;
//    }
    
//    protected function getContactService() {
//        // getServiceLocator permet de récupérer le ServiceManager
//        $sm = $this->getServiceLocator();
//        
//        //$service = $sm->get('AddressBook\Service\ContactFake');
//        $service = $sm->get('AddressBook\Service\ContactZendDb');
//        
//        return $service;
//    }
    /**
     *
     * @var Request
     */
    protected $request;


    /**
     * 
     * @var ContactServiceInterface
     */
    protected $contactService;
    
    public function __construct(ContactServiceInterface $contactService) {
        $this->contactService = $contactService;
    }

    public function listAction()
    {
        //$service = $this->getContactService();
        
        //$listeContacts = $service->getAll();
        $listeContacts = $this->contactService->getAll();
        
        return new ViewModel(array(
            'contacts' => $listeContacts
        ));
    }

    public function addAction()
    {
        $form = new ContactForm();
        
//        if($this->request->isPost()) {
//            $contact = new \AddressBook\Entity\Contact();            
//                        
//            $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
//            /* @var $em \Doctrine\ORM\EntityManager */
//            $hydrator = new DoctrineObject($em);
//            $form->setHydrator($hydrator);
//            
//            $form->bind($contact);
//            $form->setInputFilter(new ContactInputFilter());
//            $form->setData($this->request->getPost());
//            
//            if($form->isValid()) {
//                $em->persist($contact);
//                $em->flush();
//                
//                $this->flashMessenger()->addSuccessMessage('Le contact a bien été inséré');
//                
//                return $this->redirect()->toRoute('contact');
//            }
//        }
        
        if($this->request->isPost()) {
            
            $contact = $this->contactService->insert($form, $this->request->getPost());
            
            if($contact) {
                $this->flashMessenger()->addSuccessMessage('Le contact a bien été inséré');
            
                return $this->redirect()->toRoute('contact');
            }
            
        }
        
        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function showAction()
    {
        //$service = $this->getContactService();
        
        $id = $this->params('id');
        
        //$contact = $service->getById($id);
        $contact = $this->contactService->getById($id);
        
        if(!$contact) {
            // Génération d'une réponse d'erreur
            return $this->notFoundAction();
        }
        
        return new ViewModel(array(
            'contact' => $contact
        ));
    }

    public function modifyAction()
    {
        return new ViewModel();
    }

    public function deleteAction()
    {
        return new ViewModel();
    }


}

