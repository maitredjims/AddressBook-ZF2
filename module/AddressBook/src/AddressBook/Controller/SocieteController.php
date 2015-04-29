<?php

namespace AddressBook\Controller;

use AddressBook\Service\Societe\SocieteServiceInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SocieteController extends AbstractActionController
{
    /**
     *
     * @var Request
     */
    protected $request;
    
    /**
     *
     * @var SocieteServiceInterface
     */
    protected $societeService;
    
    public function __construct(SocieteServiceInterface $societeService) {
        $this->societeService = $societeService;
    }
    
    public function listAction() {
        $listeSocietes = $this->societeService->getAll();
        
        return new ViewModel(array(
            'societes' => $listeSocietes
        ));
    }
    
     public function showAction()
    {
        //$service = $this->getContactService();
        
        $id = $this->params('id');
        
        //$contact = $service->getById($id);
        $societe = $this->societeService->getById($id);
        
        if(!$societe) {
            // Génération d'une réponse d'erreur
            return $this->notFoundAction();
        }
        
        return new ViewModel(array(
            'societe' => $societe
        ));
    }
}