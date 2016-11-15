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

namespace Mkk\GearmanBundle\Tests\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Mkk\GearmanBundle\Command\GearmanJobDescribeCommand;
use Mkk\GearmanBundle\Service\GearmanClient;
use Mkk\GearmanBundle\Service\GearmanDescriber;

/**
 * Class GearmanWorkerDescribeCommandTest
 */
class GearmanWorkerDescribeCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test run
     */
    public function testRun()
    {
        $worker = array('xxx');

        /**
         * @var GearmanJobDescribeCommand $command
         * @var InputInterface $input
         * @var OutputInterface $output
         * @var KernelInterface $kernel
         * @var GearmanClient $gearmanClient
         * @var GearmanDescriber $gearmanDescriber
         */
        $command = $this
            ->getMockBuilder('Mkk\GearmanBundle\Command\GearmanWorkerDescribeCommand')
            ->setMethods(null)
            ->getMock();

        $input = $this
            ->getMockBuilder('Symfony\Component\Console\Input\InputInterface')
            ->disableOriginalConstructor()
            ->setMethods(array())
            ->getMock();

        $output = $this
            ->getMockBuilder('Symfony\Component\Console\Output\OutputInterface')
            ->disableOriginalConstructor()
            ->setMethods(array())
            ->getMock();

        $kernel = $this
            ->getMockBuilder('Symfony\Component\HttpKernel\KernelInterface')
            ->disableOriginalConstructor()
            ->setMethods(array())
            ->getMock();

        $gearmanClient = $this
            ->getMockBuilder('Mkk\GearmanBundle\Service\GearmanClient')
            ->disableOriginalConstructor()
            ->setMethods(array(
                'getWorker',
            ))
            ->getMock();

        $gearmanClient
            ->expects($this->once())
            ->method('getWorker')
            ->will($this->returnValue($worker));

        $gearmanDescriber = $this
            ->getMockBuilder('Mkk\GearmanBundle\Service\GearmanDescriber')
            ->disableOriginalConstructor()
            ->setMethods(array(
                'describeWorker',
            ))
            ->getMock();

        $gearmanDescriber
            ->expects($this->once())
            ->method('describeWorker')
            ->with($this->equalTo($output), $this->equalTo($worker));

        $command
            ->setGearmanClient($gearmanClient)
            ->setGearmanDescriber($gearmanDescriber)
            ->run($input, $output);
    }
}
