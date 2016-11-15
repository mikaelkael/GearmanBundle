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

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Exception\RuntimeException;
use Mkk\GearmanBundle\Command\GearmanWorkerDescribeCommand;

/**
 * Class GearmanWorkerDescribeCommandTest
 */
class GearmanWorkerDescribeCommandTest extends WebTestCase
{
    /**
     * test run
     */
    public function testRun()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new GearmanWorkerDescribeCommand());

        $gearmanClient = $this
            ->getMockBuilder('Mkk\GearmanBundle\Service\GearmanClient')
            ->disableOriginalConstructor()
            ->setMethods(array(
                'getWorker'
            ))
            ->getMock();

        $workers = array(
            'className'    => "Mkk\\GearmanBundle\\Tests\\Service\\Mocks\\SingleCleanFile",
            'fileName'     => dirname(__FILE__) . '/Mocks/SingleCleanFile.php',
            'namespace'    => "test",
            'callableName' => null,
            'service'      => false,
            'iterations'   => 1,
            'description'  => "test",
            'jobs'         => array(),
            'servers'      => array(),
            'job'          => array(
                'methodName'               => "myMethod",
                'callableName'             => "callableNameTest",
                'realCallableName'         => "realCallableNameTest",
                'jobPrefix'                => NULL,
                'realCallableNameNoPrefix' => "realCallableNameTest",
                'iterations'               => 1,
                'defaultMethod'            => "doBackground",
                'servers'                  => array(),
                'description'              => "test description",
            )
        );

        $gearmanClient
            ->expects($this->once())
            ->method('getWorker')
            ->will($this->returnValue($workers));

        $kernel->getContainer()->set('gearman', $gearmanClient);

        $command = $application->find('gearman:worker:describe');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),
            'worker' => 'test1'
        ));
        $this->assertContains('@Worker\className : Mkk\GearmanBundle\Tests\Service\Mocks\SingleCleanFile', $commandTester->getDisplay());
    }

    public function testRunWithoutArgumentWorker()
    {
        $this->expectException(RuntimeException::class);

        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new GearmanWorkerDescribeCommand());
        $command = $application->find('gearman:worker:describe');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),
        ));
    }
}
