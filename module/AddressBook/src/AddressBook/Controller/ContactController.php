<?php

namespace AddressBook\Controller;

use AddressBook\Form\ContactForm;
use AddressBook\InputFilter\ContactInputFilter;
use AddressBook\Service\Contact\ContactServiceInterface;
use AddressBook\Service\Societe\SocieteServiceInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\FormInterface;

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
    
    /**
     *
     * @var SocieteServiceInterface
     */
    protected $societeService;
    
    /**
     *
     * @var ContactForm
     */
    protected $contactForm;



    public function __construct(FormInterface $contactForm, ContactServiceInterface $contactService, SocieteServiceInterface $societeService) {
        $this->contactService = $contactService;
        $this->societeService = $societeService;
        
        $this->contactForm = $contactForm;
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
        //$form = new ContactForm();
        
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
        
//        $societes= $this->societeService->getAll();
//        
//        // On enregistre les sociétés dans un tableau
//        foreach ($societes as $societe) {
//            $tabSociete[$societe->getId()] = $societe->getNom();
//        } 
        
        if($this->request->isPost()) {
            
            //$contact = $this->contactService->insert($form, $this->request->getPost());
            $contact = $this->contactService->insert($this->contactForm, $this->request->getPost());
            
            if($contact) {
                $this->flashMessenger()->addSuccessMessage('Le contact a bien été inséré');
            
                return $this->redirect()->toRoute('contact');
            }
            
        }
        
        return new ViewModel(array(
            //'form' => $form,
            'form' => $this->contactForm,
            //'societes' => $tabSociete
        ));
    }

    public function showAction()
    {
        //$service = $this->getContactService();
        
        $id = $this->params('id');
        
        //$contact = $service->getById($id);
        $contact = $this->contactService->getById($id, null);
        
        if(!$contact) {
            // Génération d'une réponse d'erreur
            return $this->notFoundAction();
        }
        
        return new ViewModel(array(
            'contact' => $contact
        ));
    }

    public function updateAction()
    {
        $id = (int) $this->params('id');
        
        if(!$id) {
            return $this->redirect()->toRoute('contact');
        }
        
        $form = $this->contactForm;
        $contact = $this->contactService->getById($id, $form);
        
        //$form = new ContactForm();
                
        //$form->bind($contact);
        
//        $societes= $this->societeService->getAll();
//        
//        // On enregistre les sociétés dans un tableau
//        foreach ($societes as $societe) {
//            $tabSociete[$societe->getId()] = $societe->getNom();
//        }        
        
        if($this->request->isPost()) {
            //$contact_update = $this->contactService->update($contact, $form, $this->request->getPost());
            $contact_update = $this->contactService->update($contact, $this->contactForm, $this->request->getPost());
            
            if($contact_update) {
                $this->flashMessenger()->addSuccessMessage('Le contact a bien été modifié.');
                
                return $this->redirect()->toRoute('contact');
            }
        }
        
        return new ViewModel(array(
            'form' => $form->prepare(),
            //'societes' => $tabSociete,
        ));
    }

    public function deleteAction()
    {
        $id = (int) $this->params('id');
        
        if(!$id) {
            return $this->redirect()->toRoute('contact');
        }
        
        if ($this->request->isPost()) {
            $del = $this->request->getPost('del', 'Non');

            if ($del == 'Oui') {
                $id = (int) $this->request->getPost('id');
                $this->contactService->delete($id);
                
                $this->flashMessenger()->addSuccessMessage('Le contact a bien été supprimé.');
            }

            // Redirect to list of contact
            return $this->redirect()->toRoute('contact');
        }

        return array(
            'id' => $id,
            'contact' => $this->contactService->getById($id)
        );
    }


}

