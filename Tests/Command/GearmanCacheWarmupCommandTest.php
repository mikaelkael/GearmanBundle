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
use Mkk\GearmanBundle\Command\GearmanCacheWarmupCommand;
/**
 * Class GearmanCacheWarmupCommandTest
 */
class GearmanCacheWarmupCommandTest extends WebTestCase
{

    /**
     * Test run quietness
     */
    public function testRunQuiet()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new GearmanCacheWarmupCommand());

        $command = $application->find('gearman:cache:warmup');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),
            '--quiet' => null
        ));
    }

    /**
     * Test run without quietness
     */
    public function testRunNonQuiet()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new GearmanCacheWarmupCommand());

        $command = $application->find('gearman:cache:warmup');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName()
        ));
    }
}
