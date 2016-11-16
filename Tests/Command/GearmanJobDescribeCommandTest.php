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
use Mkk\GearmanBundle\Command\GearmanJobDescribeCommand;

/**
 * Class GearmanJobDescribeCommandTest
 */
class GearmanJobDescribeCommandTest extends WebTestCase
{
    /**
     * test run
     */
    public function testRun()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new GearmanJobDescribeCommand());

        $gearmanClient = $this
            ->getMockBuilder('Mkk\GearmanBundle\Service\GearmanClient')
            ->disableOriginalConstructor()
            ->setMethods(array(
                'getJob'
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
            ->method('getJob')
            ->will($this->returnValue($workers));

        $kernel->getContainer()->set('gearman', $gearmanClient);

        $command = $application->find('gearman:job:describe');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),
            'job' => 'test1'
        ));
        $this->assertContains('@job\callableName : realCallableNameTest', $commandTester->getDisplay());
    }

    /**
     * @expectedException RuntimeException
     */
    public function testRunWithoutArgumentJob()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new GearmanJobDescribeCommand());
        $command = $application->find('gearman:job:describe');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),
        ));
    }
}
