<?php

namespace AddressBookTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ContactControllerTest extends AbstractHttpControllerTestCase
{
    protected function setUp() {
        $this->setApplicationConfig(require 'config/application.config.php');
    }
    
    public function testListActionIsAccessible() {
        /*
        $contact = new \Zend\Stdlib\ArrayObject();
        
        $this->assertTrue($contact instanceof \Zend\Stdlib\ArrayObject);
        */
        
       $this->dispatch('/contact');
       
       //var_dump($this->getApplicationServiceLocator()->get('Config')['doctrine']);
       //var_dump($this->getResponse()->getContent());
       
       $this->assertResponseStatusCode(200);
       $this->assertModuleName('addressbook');
       $this->assertControllerName('addressbook\controller\contact');
       $this->assertActionName('list');
       $this->assertMatchedRouteName('contact');
       
    }
    
    /*
    // Problème : test dépendant de la base de données. Il faudrait remplir la base avant chaque test.
    public function testShowActionContainsContactWithMysql() {
        $this->dispatch('/contact/2');
        
        // On vérifie via un sélecteur CSS (attetion, tous n'existent pas) qu'il y a bien 3 paragraphes
        $this->assertQueryCount('p', 3);
        $this->assertContains('Malik', $this->getResponse()->getContent());
        $this->assertContains('Djimbi', $this->getResponse()->getContent());
    }
    */
    
    public function testShowActionContainsWithFake() {
        $dataTest = [
            (new \AddressBook\Entity\Contact)->setId(10)
                ->setPrenom('Alain')
                ->setNom('Delon')
        ];
        
        $fakeService = new \AddressBook\Service\Contact\ContactFakeService($dataTest);
        
        $this->getApplicationServiceLocator()
                ->setAllowOverride(true)
                ->setService('AddressBook\Service\Contact', $fakeService);
        
        $this->dispatch('/contact/10');
        
        $this->assertContains('Alain', $this->getResponse()->getContent());
        $this->assertContains('Delon', $this->getResponse()->getContent());
    }
    
    public function testShowActionContainsWithMock() {
        //$mockService = $this->getMockBuilder(\AddressBook\Service\Contact\ContactServiceInterface::class)->getMock();
        
        $mockService = $this->getMockBuilder(\AddressBook\Service\Contact\ContactDoctrineService::class)
                ->disableOriginalConstructor()
                ->getMock();
        
        $mockService->expects($this->once())
                ->method('getById')
                ->willReturn((new \AddressBook\Entity\Contact)
                        ->setId('1')
                        ->setPrenom('Zinedine')
                        ->setNom('Zidane'));
        
        $this->getApplicationServiceLocator()
                ->setAllowOverride(true)
                ->setService('AddressBook\Service\Contact', $mockService);
        
        $this->dispatch('/contact/1');
        $this->assertQueryCount('p', 4);
        $this->assertContains('Zinedine', $this->getResponse()->getContent());
        $this->assertContains('Zidane', $this->getResponse()->getContent());
    }
}
