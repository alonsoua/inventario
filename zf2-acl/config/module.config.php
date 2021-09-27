<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2Acl;

return array(
	'router' => array(
		'routes' => array(
			'acl-all' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/admin/acl',
					'defaults' => array(
						'__NAMESPACE__' => __NAMESPACE__ . '\Controller',
						'controller' => 'Role',
						'action' => 'index'
					)
				),
				'may_terminate' => true,
				'child_routes' => array(
					'default' => array(
						'type' => 'Segment',
						'options' => array(
							'route' => '/[:controller[/:action[/:id]]]',
							'constraints' => array(
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id' => '\d+'
							),
							'defaults' => array(
								'__NAMESPACE__' => __NAMESPACE__ . '\Controller',
								'controller' => 'Role'
							)
						)
					),
					'paginator' => array(
						'type' => 'Segment',
						'options' => array(
							'route' => '/[:controller[/page/:page]]',
							'constraints' => array(
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'page' => '\d+'
							),
							'defaults' => array(
								'__NAMESPACE__' => __NAMESPACE__ . '\Controller',
								'controller' => 'Role'
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
				'label' => 'Permisos',
				'route' => 'acl-all',
				'resource'=> __NAMESPACE__ . '\Controller\Role',
				'pages' => array(
					array(
						'label' => 'Lista de Perfiles',
						'route' => 'acl-all/default',
						'params' => array('controller' => 'role'),
						'resource'=> __NAMESPACE__ . '\Controller\Role',
					),
					array(
						'label' => 'Nuevo Perfil',
						'route' => 'acl-all/default',
						'params' => array('controller' => 'role', 'action' => 'register'),
						'resource'=> __NAMESPACE__ . '\Controller\Role',
					),
					array(
						'label' => 'Lista de Recursos',
						'route' => 'acl-all/default',
						'params' => array('controller' => 'resource'),
						'resource'=> __NAMESPACE__ . '\Controller\Resource',
					),
					array(
						'label' => 'Nuevo Recurso',
						'route' => 'acl-all/default',
						'params' => array('controller' => 'resource', 'action' => 'register'),
						'resource'=> __NAMESPACE__ . '\Controller\Resource',
					),
					array(
						'label' => 'Lista de Privilegios',
						'route' => 'acl-all/default',
						'params' => array('controller' => 'privilege'),
						'resource'=> __NAMESPACE__ . '\Controller\Privilege',
					),
					array(
						'label' => 'Nuevo Privilegio',
						'route' => 'acl-all/default',
						'params' => array('controller' => 'privilege', 'action' => 'register'),
						'resource'=> __NAMESPACE__ . '\Controller\Privilege',
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
			__NAMESPACE__ . '\Controller\Role' => __NAMESPACE__ . '\Controller\RoleController',
			__NAMESPACE__ . '\Controller\Resource' => __NAMESPACE__ . '\Controller\ResourceController',
			__NAMESPACE__ . '\Controller\Privilege' => __NAMESPACE__ . '\Controller\PrivilegeController',
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
