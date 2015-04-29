<?php

return array(
    'service_manager' => array(
        // permet de choisir un service en fonction de l'environnement (dev, prod, test,...)
        'aliases' => array(
            //'AddressBook\Service\Contact' => 'AddressBook\Service\ContactFake',
            //'AddressBook\Service\Contact' => 'AddressBook\Service\ContactZendDb',
            'AddressBook\Service\Contact' => 'AddressBook\Service\ContactDoctrineORM',
            'AddressBook\Service\Societe' => 'AddressBook\Service\SocieteDoctrineORM',
        ),
    ),
);

