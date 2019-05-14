<?php

namespace Appoint;

// import Zend modules:
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

// ModuleMnager to load and configure appointment module
class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\AppointController::class => function($container) {
                    return new Controller\AppointController(
                        $container->get(Model\AppointTable::class)
                    );
                },
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\AppointTable::class => function($container) {
                    $tableGateway = $container->get(Model\AppointTableGateway::class);
                    return new Model\AppointTable($tableGateway);
                },
                Model\AppointTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Appoint());
                    return new TableGateway('appoint', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }
}