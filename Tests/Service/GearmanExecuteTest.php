<?php

/**
 * Gearman Bundle for Symfony2 / Symfony3
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 */

namespace Mkk\GearmanBundle\Tests\Service;

use Mkk\GearmanBundle\Service\GearmanExecute;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Mkk\GearmanBundle\GearmanEvents;

/**
 * Tests GearmanExecute class
 */
class GearmanExecuteTest extends WebTestCase
{

    /**
     * Test service can be instanced through container
     */
    public function testGearmanExecuteLoadFromContainer()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $this->assertInstanceOf(
            '\Mkk\GearmanBundle\Service\GearmanExecute',
            static::$kernel
                ->getContainer()
                ->get('gearman.execute')
        );
    }

    public function testDispatchingEventsOnJob()
    {
        // Worker mock
        $worker = $this->getMockBuilder('\GearmanWorker')
            ->disableOriginalConstructor()
            ->getMock();
        $worker->method('addServer')->willReturn(true);

        // Wrapper mock
        $workers = array(
            0 => array(
                'className'    => "Mkk\\GearmanBundle\\Tests\\Service\\Mocks\\SingleCleanFile",
                'fileName'     => dirname(__FILE__) . '/Mocks/SingleCleanFile.php',
                'callableName' => null,
                'description'  => "test",
                'service'      => false,
                'servers'      => array(),
                'iterations'   => 1,
                'timeout'      => null,
                'minimumExecutionTime' => null,
                'jobs' => array(
                    0 => array(
                        'callableName'             => "callableNameTest",
                        'methodName'               => "myMethod",
                        'realCallableName'         => "realCallableNameTest",
                        'jobPrefix'                => NULL,
                        'realCallableNameNoPrefix' => "realCallableNameTest",
                        'description'              => "test description",
                        'iterations'               => 1,
                        'servers'                  => array(),
                        'defaultMethod'            => "doBackground",
                        'minimumExecutionTime'     => null,
                        'timeout'                  => null,
                    )
                )
            )
        );
        $wrapper = $this->getMockBuilder('Mkk\GearmanBundle\Service\GearmanCacheWrapper')
            ->disableOriginalConstructor()
            ->getMock();
        $wrapper->method('getWorkers')
            ->willReturn($workers);

        // Prepare a dispatcher to listen to tested events
        $startingFlag = false;
        $executedFlag = false;

        $dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
        $dispatcher->addListener(GearmanEvents::GEARMAN_WORK_STARTING, function() use (&$startingFlag){
            $startingFlag = true;
        });
        $dispatcher->addListener(GearmanEvents::GEARMAN_WORK_EXECUTED, function() use (&$executedFlag){
            $executedFlag = true;
        });

        // We need a job object, this part could be improved
        $object = new \Mkk\GearmanBundle\Tests\Service\Mocks\SingleCleanFile();

        // Create the service under test
        $service = new GearmanExecute($wrapper, array());
        $service->setEventDispatcher($dispatcher);

        $job = $this->getMockBuilder('\GearmanJob')
            ->disableOriginalConstructor()
            ->getMock();
        $job->method('functionName')->will($this->returnValue('realCallableNameTest'));

        // Finalize worker mock by making it call our job object
        // This is normally handled by Gearman, but for test purpose we must simulate it
        $worker->method('work')->will($this->returnCallback(function() use ($service, $job){
            $service->handleJob($job);
            return true;
        }));

        // Execute a job :)
        $service->executeJob('realCallableNameTest', array(), $worker);

        // Do we have the events ?
        $this->assertTrue($startingFlag);
        $this->assertTrue($executedFlag);
    }
}
