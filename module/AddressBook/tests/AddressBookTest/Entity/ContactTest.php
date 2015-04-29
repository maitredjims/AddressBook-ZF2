<?php

namespace AddressBookTest\Entity;

use AddressBook\Entity\Contact;
use PHPUnit_Framework_TestCase;


class ContactTest extends PHPUnit_Framework_TestCase {

    protected $contact;

    // Méthode appellée avant chaque test de cette classe
    protected function setUp() {
        $this->contact = new Contact();
    }

    // Méthode qui va être appellée une fois avant l'éxécution des tests de cette classe
    public static function setUpBeforeClass() {
        require_once __DIR__ . '/../../../src/AddressBook/Entity/Contact.php';
    }

    // Après chaque test de cette classe
    protected function tearDown() {
        parent::tearDown();
    }

    // A la fin de tous les tests de chaque classe
    public static function tearDownAfterClass() {
        parent::tearDownAfterClass();
    }

    public function testInitValuesAreNull() {
        $this->assertNull($this->contact->getId());
        $this->assertNull($this->contact->getNom());
        $this->assertNull($this->contact->getPrenom());
        $this->assertNull($this->contact->getSociete());
        $this->assertNull($this->contact->getTelephone());
        $this->assertNull($this->contact->getEmail());
    }

}
