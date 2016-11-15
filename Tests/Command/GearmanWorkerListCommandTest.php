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
 * @author Mickael Perraud <mikaelkael.fr@gmail.com>
 */

namespace Mkk\GearmanBundle\Tests\Command;

use Mkk\GearmanBundle\Command\GearmanWorkerListCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Tester\CommandTester;
/**
 * Class GearmanWorkerListCommandTest
 */
class GearmanWorkerListCommandTest extends WebTestCase
{
    /**
     * Test run
     */
    public function testRunWithWorker()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new GearmanWorkerListCommand());

        $gearmanClient = $this
            ->getMockBuilder('Mkk\GearmanBundle\Service\GearmanClient')
            ->disableOriginalConstructor()
            ->setMethods(array(
                'getWorkers'
            ))
            ->getMock();
        $workers = array(
            array(
                'className'    => "Mkk\\GearmanBundle\\Tests\\Service\\Mocks\\SingleCleanFile",
                'fileName'     => dirname(__FILE__) . '/Mocks/SingleCleanFile.php',
                'namespace'    => "test",
                'callableName' => null,
                'service'      => false,
                'iterations'   => 1,
                'description'  => "test",
                'jobs'         => array(),
                'servers'      => array(),
                'jobs'         => array(
                    array(
                        'methodName'               => "myMethod",
                        'callableName'             => "callableNameTest",
                        'realCallableName'         => "realCallableNameTest",
                        'jobPrefix'                => NULL,
                        'realCallableNameNoPrefix' => "realCallableNameTest",
                        'iterations'               => 1,
                        'defaultMethod'            => "doBackground",
                        'servers'                  => array(),
                        'description'              => "test description"
                    )
                )
            )
        );
        $gearmanClient
            ->expects($this->once())
            ->method('getWorkers')
            ->will($this->returnValue($workers));
        $kernel->getContainer()->set('gearman', $gearmanClient);

        $command       = $application->find('gearman:worker:list');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName()
        ));
        $this->assertContains('@Worker:  Mkk\GearmanBundle\Tests\Service\Mocks\SingleCleanFile', $commandTester->getDisplay());
        $this->assertContains('callablename: realCallableNameTest', $commandTester->getDisplay());
    }

    /**
     * Test run
     */
    public function testRunWithoutWorker()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new GearmanWorkerListCommand());

        $command       = $application->find('gearman:worker:list');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName()
        ));
        $this->assertEmpty($commandTester->getDisplay());
    }
}
