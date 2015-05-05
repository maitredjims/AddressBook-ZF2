<?php

namespace AddressBook\Controller;

use AddressBook\Service\Societe\SocieteServiceInterface;
use AddressBook\Form\SocieteForm;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SocieteController extends AbstractActionController {

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

    public function showAction() {

        $id = $this->params('id');

        $societe = $this->societeService->getById($id);

        if (!$societe) {
            // Génération d'une réponse d'erreur
            return $this->notFoundAction();
        }

        return new ViewModel(array(
            'societe' => $societe
        ));
    }

    public function addAction() {
        $form = new SocieteForm();

        if ($this->request->isPost()) {

            $contact = $this->societeService->insert($form, $this->request->getPost());

            if ($contact) {
                $this->flashMessenger()->addSuccessMessage('La société a bien été inséré');

                return $this->redirect()->toRoute('societe');
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function updateAction() {
        $id = (int) $this->params('id');

        if (!$id) {
            return $this->redirect()->toRoute('societe');
        }
        
        $form = new SocieteForm();
        $societe = $this->societeService->getById($id, $form);
        
        //var_dump($societe);
                
        //$form->bind($societe);

        if ($this->request->isPost()) {
            $societe_update = $this->societeService->update($societe, $form, $this->request->getPost());

            if ($societe_update) {
                return $this->redirect()->toRoute('societe');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function deleteAction() {
        $id = (int) $this->params('id');

        if (!$id) {
            return $this->redirect()->toRoute('societe');
        }

        if ($this->request->isPost()) {
            $del = $this->request->getPost('del', 'Non');

            if ($del == 'Oui') {
                $id = (int) $this->request->getPost('id');
                $this->societeService->delete($id);
            }

            // Redirect to list of contact
            return $this->redirect()->toRoute('societe');
        }

        return array(
            'id' => $id,
            'societe' => $this->societeService->getById($id)
        );
    }

}
