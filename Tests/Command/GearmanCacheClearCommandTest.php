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
use Mkk\GearmanBundle\Command\GearmanCacheClearCommand;
use Mkk\GearmanBundle\Service\GearmanCacheWrapper;

/**
 * Class GearmanCacheClearCommandTest
 */
class GearmanCacheClearCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GearmanCacheClearCommand
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
     * @var GearmanCacheWrapper
     *
     * Gearman Cache Wrapper
     */
    protected $gearmanCacheWrapper;

    /**
     * Set up method
     */
    public function setUp()
    {
        $this->command = $this
            ->getMockBuilder('Mkk\GearmanBundle\Command\GearmanCacheClearCommand')
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

        $this->gearmanCacheWrapper = $this
            ->getMockBuilder('Mkk\GearmanBundle\Service\GearmanCacheWrapper')
            ->disableOriginalConstructor()
            ->setMethods(array(
                'clear',
            ))
            ->getMock();

        $this
            ->gearmanCacheWrapper
            ->expects($this->once())
            ->method('clear');

        $this
            ->command
            ->setGearmanCacheWrapper($this->gearmanCacheWrapper);
    }

    /**
     * Test run quietness
     */
    public function testRunQuiet()
    {
        $this
            ->input
            ->expects($this->any())
            ->method('getOption')
            ->will($this->returnValueMap(array(
                array('quiet', true)
            )));

        $this
            ->output
            ->expects($this->never())
            ->method('writeln');

        $this
            ->command
            ->run(
                $this->input,
                $this->output
            );
    }

    /**
     * Test run without quietness
     */
    public function testRunNonQuiet()
    {
        $this
            ->input
            ->expects($this->any())
            ->method('getOption')
            ->will($this->returnValueMap(array(
                array('quiet', false)
            )));

        $this
            ->output
            ->expects($this->any())
            ->method('writeln');

        $this
            ->command
            ->run(
                $this->input,
                $this->output
            );
    }
}
