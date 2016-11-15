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

use Mkk\GearmanBundle\Command\GearmanJobExecuteCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class GearmanJobExecuteCommandTest
 */
class GearmanJobExecuteCommandTest extends WebTestCase
{

    /**
     * Test run
     */
    public function testRun()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new GearmanJobExecuteCommand());

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
        $gearmanExecute = $this
            ->getMockBuilder('Mkk\GearmanBundle\Service\GearmanExecute')
            ->disableOriginalConstructor()
            ->setMethods(array(
                'executeJob'
            ))
            ->getMock();
        $kernel->getContainer()->set('gearman', $gearmanClient);
        $kernel->getContainer()->set('gearman.execute', $gearmanExecute);

        $question = $this
            ->getMockBuilder('Symfony\Component\Console\Helper\QuestionHelper')
            ->disableOriginalConstructor()
            ->setMethods(array(
                'ask'
            ))
            ->getMock();
        $question
            ->expects($this->once())
            ->method('ask')
            ->will($this->returnValue(true));

        $command       = $application->find('gearman:job:execute');
        $command->getHelperSet()->set($question, 'question');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),
            'job'     => 'test'
        ));
        $this->assertContains('loading...', $commandTester->getDisplay());
        $this->assertContains('@job\callableName : realCallableNameTest', $commandTester->getDisplay());
    }

    /**
     * Test run with no interaction
     */
    public function testRunNoInteraction()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new GearmanJobExecuteCommand());

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
        $gearmanExecute = $this
            ->getMockBuilder('Mkk\GearmanBundle\Service\GearmanExecute')
            ->disableOriginalConstructor()
            ->setMethods(array(
                'executeJob'
            ))
            ->getMock();
        $kernel->getContainer()->set('gearman', $gearmanClient);
        $kernel->getContainer()->set('gearman.execute', $gearmanExecute);

        $question = $this
            ->getMockBuilder('Symfony\Component\Console\Helper\QuestionHelper')
            ->disableOriginalConstructor()
            ->setMethods(array(
                'ask'
            ))
            ->getMock();
        $question
            ->expects($this->never())
            ->method('ask')
            ->will($this->returnValue(true));

        $command       = $application->find('gearman:job:execute');
        $command->getHelperSet()->set($question, 'question');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),
            'job'     => 'test',
            '--no-interaction' => null
        ));
        $this->assertContains('loading...', $commandTester->getDisplay());
        $this->assertContains('@job\callableName : realCallableNameTest', $commandTester->getDisplay());
    }


    /**
     * Test run quietness
     */
    public function testRunQuietness()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new GearmanJobExecuteCommand());

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
        $gearmanExecute = $this
            ->getMockBuilder('Mkk\GearmanBundle\Service\GearmanExecute')
            ->disableOriginalConstructor()
            ->setMethods(array(
                'executeJob'
            ))
            ->getMock();
        $kernel->getContainer()->set('gearman', $gearmanClient);
        $kernel->getContainer()->set('gearman.execute', $gearmanExecute);

        $question = $this
            ->getMockBuilder('Symfony\Component\Console\Helper\QuestionHelper')
            ->disableOriginalConstructor()
            ->setMethods(array(
                'ask'
            ))
            ->getMock();
        $question
            ->expects($this->once())
            ->method('ask')
            ->will($this->returnValue(true));

        $command       = $application->find('gearman:job:execute');
        $command->getHelperSet()->set($question, 'question');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),
            'job'     => 'test',
            '--quiet' => null
        ));
        $this->assertEmpty($commandTester->getDisplay());
    }
}
