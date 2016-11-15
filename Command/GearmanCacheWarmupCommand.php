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

namespace Mkk\GearmanBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Mkk\GearmanBundle\Command\Abstracts\AbstractGearmanCommand;
use Mkk\GearmanBundle\Service\GearmanCacheWrapper;

/**
 * Warms up all cache data
 */
class GearmanCacheWarmupCommand extends AbstractGearmanCommand
{
    /**
     * @var GearmanCacheWrapper
     *
     * GearmanCacheWrapper
     */
    protected $gearmanCacheWrapper;

    /**
     * Set the GearmanCacheWrapper instance
     *
     * @param GearmanCacheWrapper $gearmanCacheWrapper GearmanCacheWrapper
     *
     * @return GearmanCacheWarmupCommand self Object
     */
    public function setGearmanCacheWrapper(GearmanCacheWrapper $gearmanCacheWrapper)
    {
        $this->gearmanCacheWrapper = $gearmanCacheWrapper;

        return $this;
    }

    /**
     * Console Command configuration
     */
    protected function configure()
    {
        $this
            ->setName('gearman:cache:warmup')
            ->setAliases(array(
                'cache:gearman:warmup'
            ))
            ->setDescription('Warms up gearman cache data');
    }

    /**
     * Executes the current command.
     *
     * @param InputInterface  $input  An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     *
     * @return integer 0 if everything went fine, or an error code
     *
     * @throws \LogicException When this abstract class is not implemented
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (
            !$input->getOption('quiet')
        ) {
            $output->writeln('Warming the cache for the ' . $this->environment . ' environment');
        }

        $this
            ->gearmanCacheWrapper
            ->warmup('');
    }
}
