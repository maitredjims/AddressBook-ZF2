<?php

return array(
    'controllers' => array(
//        'invokables' => array(
//            // ::class n'existe que depuis PHP 5.5
//            'AddressBook\Controller\Contact' => \AddressBook\Controller\ContactController::class
//        ),
        'factories' => array(
//            'AddressBook\Controller\Contact' => function($cm) {
//                // cm => ControllerManager
//                $sm = $cm->getServiceLocator();
//                $contactService = $sm->get('AddressBook\Service\Contact');
//                $societeService = $sm->get('AddressBook\Service\Societe');
//                //$contactService = $sm->get('AddressBook\Service\ContactFake');
//                return new AddressBook\Controller\ContactController($contactService, $societeService);
//            },
            'AddressBook\Controller\Contact' => AddressBook\Factory\Controller\ContactControllerFactory::class,
            'AddressBook\Controller\Societe' => function($cm) {
                // cm => ControllerManager
                $sm = $cm->getServiceLocator();
                $societeService = $sm->get('AddressBook\Service\Societe');
                //$contactService = $sm->get('AddressBook\Service\ContactFake');
                return new AddressBook\Controller\SocieteController($societeService);
            },
        ),
    ),
    // Factory pour le formulaire
    'form_elements' => array(
        'factories' => array(
            'AddressBook\Form\ContactForm' => AddressBook\Factory\Form\ContactFormFactory::class,
        ),
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'AddressBook\Controller\Contact',
                        'action' => 'list',
                    ),
                ),
            ),
            'contact' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/contact',
                    'defaults' => array(
                        'controller' => 'AddressBook\Controller\Contact',
                        'action' => 'list',
                    ),
                ),
                // indique au routeur s'il y a un segment à suivre
                'may_terminate' => true,
                // routes enfants de /contact
                'child_routes' => array(
                    'add' => array(
                        'type' => \Zend\Mvc\Router\Http\Literal::class,
                        'options' => array(
                            'route' => '/add',
                            'defaults' => array(
                                'action' => 'add',
                            ),
                        ),
                    ),
                    'show' => array(
                        'type' => Zend\Mvc\Router\Http\Segment::class,
                        'options' => array(
                            'route' => '/:id',
                            'defaults' => array(
                                'action' => 'show',
                            ),
                            'constraints' => array(
                                'id' => '[1-9][0-9]*'
                            ),
                        ),
                    ),
                    'update' => array(
                        'type' => \Zend\Mvc\Router\Http\Segment::class,
                        'options' => array(
                            'route' => '/update/:id',
                            'defaults' => array(
                                'action' => 'update',
                            ),
                            'constraints' => array(
                                'id' => '[1-9][0-9]*'
                            ),
                        ),
                    ),
                    'delete' => array(
                        'type' => \Zend\Mvc\Router\Http\Segment::class,
                        'options' => array(
                            'route' => '/delete/:id',
                            'defaults' => array(
                                'action' => 'delete',
                            ),
                            'constraints' => array(
                                'id' => '[1-9][0-9]*'
                            ),
                        ),
                    ),
                ),
            ),
            'societe' => array(
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => array(
                    'route' => '/societe',
                    'defaults' => array(
                        'controller' => 'AddressBook\Controller\Societe',
                        'action' => 'list',
                    ),
                ),
                // indique au routeur s'il y a un segment à suivre
                'may_terminate' => true,
                // routes enfants de /contact
                'child_routes' => array(
                    'add' => array(
                        'type' => \Zend\Mvc\Router\Http\Literal::class,
                        'options' => array(
                            'route' => '/add',
                            'defaults' => array(
                                'action' => 'add',
                            ),
                        ),
                    ),
                    'show' => array(
                        'type' => Zend\Mvc\Router\Http\Segment::class,
                        'options' => array(
                            'route' => '/:id',
                            'defaults' => array(
                                'action' => 'show',
                            ),
                            'constraints' => array(
                                'id' => '[1-9][0-9]*'
                            ),
                        ),
                    ),
                    'update' => array(
                        'type' => \Zend\Mvc\Router\Http\Segment::class,
                        'options' => array(
                            'route' => '/update/:id',
                            'defaults' => array(
                                'action' => 'update',
                            ),
                            'constraints' => array(
                                'id' => '[1-9][0-9]*'
                            ),
                        ),
                    ),
                    'delete' => array(
                        'type' => \Zend\Mvc\Router\Http\Segment::class,
                        'options' => array(
                            'route' => '/delete/:id',
                            'defaults' => array(
                                'action' => 'delete',
                            ),
                            'constraints' => array(
                                'id' => '[1-9][0-9]*'
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    // Pour expliquer où sont les routes du module
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        // Définition de notre propre template
        /*
          'template_map' => array(
          'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
          //'error/404'               => __DIR__ . '/../view/error/404.phtml',
          //'error/index'             => __DIR__ . '/../view/error/index.phtml',
          ),
         */
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'AddressBook\Service\ContactFake' => AddressBook\Service\Contact\ContactFakeService::class,
        ),
        'factories' => array(
            'AddressBook\Service\ContactZendDb' => function($sm) {
                $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                $tableGateway = new \Zend\Db\TableGateway\TableGateway('contact', $adapter);
                $service = new \AddressBook\Service\Contact\ContactZendDbService($tableGateway);
        
                return $service;
            },
            'AddressBook\Service\ContactDoctrineORM' => function($sm) {
                
                $om = $sm->get('Doctrine\ORM\EntityManager');
                $service = new \AddressBook\Service\Contact\ContactDoctrineService($om);
        
                return $service;
            },
            'AddressBook\Service\SocieteDoctrineORM' => function($sm) {
                
                $om = $sm->get('Doctrine\ORM\EntityManager');
                $service = new \AddressBook\Service\Societe\SocieteDoctrineService($om);
        
                return $service;
            },
        ),
        'aliases' => array(
            'AddressBook\Service\Contact' => 'AddressBook\Service\ContactFake',
            //'AddressBook\Service\Contact' => 'AddressBook\Service\ContactZendDb',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'my_annotation_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__.'/../src/AddressBook/Entity',
                ),
            ),

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => array(
                'drivers' => array(
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    'AddressBook\Entity' => 'my_annotation_driver'
                ),
            ),
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
);
