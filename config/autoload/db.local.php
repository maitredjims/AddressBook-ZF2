<?php

return array(
    'db' => array(
        'username' => 'root',
        'password' => '',
    ),
    'service_manager' => array(
        'factories' => array(
            //'Zend\Db\Adapter\Adapter' => \Zend\Db\Adapter\AdapterServiceFactory::class,
            // Config de développement
            'Zend\Db\Adapter\Adapter' => BjyProfiler\Db\Adapter\ProfilingAdapterFactory::class,
        ),
    ),
);

