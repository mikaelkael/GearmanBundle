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

namespace Mkk\GearmanBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

/**
 * Gearman Job Describe Command class
 */
class GearmanWorkerDescribeCommand extends ContainerAwareCommand
{
    /**
     * Console Command configuration
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('gearman:worker:describe')
            ->setDescription('Describe given worker')
            ->addArgument(
                'worker',
                InputArgument::REQUIRED,
                'worker to describe'
            );
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
        $worker = $input->getArgument('worker');
        $worker = $this
            ->getContainer()->get('gearman')
            ->getWorker($worker);

        $this
            ->getContainer()->get('gearman.describer')
            ->describeWorker(
                $output,
                $worker
            );
    }
}
