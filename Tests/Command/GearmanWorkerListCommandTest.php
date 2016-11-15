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
use Mkk\GearmanBundle\Command\GearmanWorkerListCommand;
use Mkk\GearmanBundle\Service\GearmanClient;

/**
 * Class GearmanWorkerListCommandTest
 */
class GearmanWorkerListCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GearmanWorkerListCommand
     *
     * Command
     */
    protected $command;

    /**
     * @var InputInterface
     *
     * Input
     */
    protected $input;

    /**
     * @var OutputInterface
     *
     * Output
     */
    protected $output;

    /**
     * @var GearmanClient
     *
     * Gearman client
     */
    protected $gearmanClient;

    /**
     * setup
     */
    public function setUp()
    {
        $this->command = $this
            ->getMockBuilder('Mkk\GearmanBundle\Command\GearmanWorkerListCommand')
            ->setMethods(null)
            ->getMock();

        $this->input = $this
            ->getMockBuilder('Symfony\Component\Console\Input\InputInterface')
            ->disableOriginalConstructor()
            ->setMethods(array())
            ->getMock();

        $this->output = $this
            ->getMockBuilder('Symfony\Component\Console\Output\OutputInterface')
            ->disableOriginalConstructor()
            ->setMethods(array())
            ->getMock();

        $this->gearmanClient = $this
            ->getMockBuilder('Mkk\GearmanBundle\Service\GearmanClient')
            ->disableOriginalConstructor()
            ->setMethods(array(
                'getWorkers',
            ))
            ->getMock();

        $this->gearmanClient
            ->expects($this->any())
            ->method('getWorkers')
            ->will($this->returnValue(array(
                array(
                    'className'    => '',
                    'callableName' => '',
                    'jobs'         => array()
                ),
            )));

    }

    /**
     * Test quietness
     *
     * @dataProvider dataQuietness
     */
    public function testQuietness(
        $quiet,
        $countWriteln
    )
    {
        $this
            ->input
            ->expects($this->any())
            ->method('getOption')
            ->will($this->returnValueMap(array(
                array('quiet', $quiet)
            )));

        $this
            ->output
            ->expects($countWriteln)
            ->method('writeln');

        $this->command
            ->setGearmanClient($this->gearmanClient)
            ->run($this->input, $this->output);
    }

    /**
     * Data provider for testQuietness
     */
    public function dataQuietness()
    {
        return array(
            array(
                true,
                $this->never(),
            ),
            array(
                false,
                $this->atLeastOnce(),
            ),
        );
    }
}
