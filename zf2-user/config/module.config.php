<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2User;

return array(
    'router' => array(
        'routes' => array(
            'user-auth' => array(
              'type' => 'Literal',
                'options' => array(
                    'route'=>'/auth',
                    'defaults' => array(
                        '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                        'controller' => 'Auth',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:action[/:key]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                                'controller' => 'Auth'
                            )
                        )
                    )
                )
            ),
            'user-admin' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/user',
                    'defaults' => array(
                        '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:action[/:id]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '\d+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                                'controller' => 'Index'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/page/:page]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                                'controller' => 'Index'
                            )
                        )
                    )
                )
            )
        )
    ),
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Usuarios',
                'route' => 'user-admin',
                'resource'=> __NAMESPACE__ . '\Controller\Index',
                'pages' => array(
                    array(
                        'label' => 'Lista de Usuarios',
                        'route' => 'user-admin/default',
                        'params' => array('controller' => 'index'),
                        'resource'=> __NAMESPACE__ . '\Controller\Index',
                    ),
                    array(
                        'label' => 'Nuevo Usuario',
                        'route' => 'user-admin/default',
                        'params' => array('controller' => 'index', 'action' => 'register'),
                        'resource'=> __NAMESPACE__ . '\Controller\Index',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            __NAMESPACE__ . '\Controller\Index' => __NAMESPACE__ . '\Controller\IndexController',
            __NAMESPACE__ . '\Controller\Auth' => __NAMESPACE__ . '\Controller\AuthController',
        )
    ),
    'view_manager' => array(
        'display_not_found_rea' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ),
            ),
        ),
    ),
    'data-fixture' => array(
        __NAMESPACE__ . '_fixture' => __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity/Fixture',
    )
);
