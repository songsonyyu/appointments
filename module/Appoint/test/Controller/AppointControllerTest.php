<?php
namespace Appoint\Test\Controller;

use Appoint\Controller\AppointController;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Appoint\Model\AppointTable;
use Zend\ServiceManager\ServiceManager;
use Appoint\Model\Appoint;
use Prophecy\Argument;

class AppointControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = True;
    protected $appointTable;

    public function setUp()
    {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            // Grabbing the full application configuration:
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));
        parent::setUp();

        $this->configureServiceManager($this->getApplicationServiceLocator());
        $services = $this->getApplicationServiceLocator();
        $config = $services->get('config');
        unset($config['db']);
        $services->setAllowOverride(true);
        $services->setService('config', $config);
        $services->setAllowOverride(false);
        
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->appointTable->fetchAll()->willReturn([]);
        $this->dispatch('/appoint');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Appoint');
        $this->assertControllerName(AppointController::class);
        $this->assertControllerClass('AppointController');
        $this->assertMatchedRouteName('appoint');
    }

    protected function configureServiceManager(ServiceManager $services)
    {
        $services->setAllowOverride(true);

        $services->setService('config', $this->updateConfig($services->get('config')));
        $services->setService(AppointTable::class, $this->mockAppointTable()->reveal());

        $services->setAllowOverride(false);
    }

    protected function updateConfig($config)
    {
        $config['db'] = [];
        return $config;
    }

    protected function mockAppointTable()
    {
        $this->appointTable = $this->prophesize(AppointTable::class);
        return $this->appointTable;
    }

    public function testAddActionRedirectsAfterValidPost()
    {
        $this->appointTable
            ->saveAppoint(Argument::type(Appoint::class))
            ->shouldBeCalled();

        $postData = [
            'endTime'  => '12:00',
            'startTime'  => '10:00',
            'reason'  => 'CT Scan',
            'patientName' => 'Paul Frank',
            'id'     => '10',
        ];
        $this->dispatch('/appoint/add', 'POST', $postData);
        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/appoint');
    }
}