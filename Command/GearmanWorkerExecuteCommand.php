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

use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Gearman Worker Execute Command class
 */
class GearmanWorkerExecuteCommand extends ContainerAwareCommand
{
    /**
     * Console Command configuration
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('gearman:worker:execute')
            ->setDescription('Execute one worker with all contained Jobs')
            ->addArgument(
                'worker',
                InputArgument::REQUIRED,
                'work to execute'
            )
            ->addOption(
                'no-description',
                null,
                InputOption::VALUE_NONE,
                'Don\'t print worker description'
            )
            ->addOption(
                'iterations',
                null,
                InputOption::VALUE_OPTIONAL,
                'Override configured iterations'
            )
            ->addOption(
                'minimum-execution-time',
                null,
                InputOption::VALUE_OPTIONAL,
                'Override configured minimum execution time'
            )
            ->addOption(
                'timeout',
                null,
                InputOption::VALUE_OPTIONAL,
                'Override configured timeout'
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
        /**
         * @var QuestionHelper $question
         */
        $question = $this
            ->getHelperSet()
            ->get('question');

        if (
            !$input->getOption('no-interaction') &&
            !$question->ask(
                $input,
                $output,
                new ConfirmationQuestion('This will execute asked worker with all its jobs?')
            )
        ) {
            return;
        }

        if (!$input->getOption('quiet')) {

            $output->writeln(sprintf(
                '<info>[%s] loading...</info>',
                date('Y-m-d H:i:s')
            ));
        }

        $worker = $input->getArgument('worker');

        $workerStructure = $this
            ->getContainer()->get('gearman')
            ->getWorker($worker);

        if (
            !$input->getOption('no-description') &&
            !$input->getOption('quiet')
        ) {
            $this
                ->getContainer()->get('gearman.describer')
                ->describeWorker(
                    $output,
                    $workerStructure,
                    true
                );
        }

        if (!$input->getOption('quiet')) {

            $output->writeln(sprintf(
                '<info>[%s] loaded. Ctrl+C to break</info>',
                date('Y-m-d H:i:s')
            ));
        }

        $this
            ->getContainer()->get('gearman.execute')
            ->setOutput($output)
            ->executeWorker($worker, array(
                'iterations'             => $input->getOption('iterations'),
                'minimum_execution_time' => $input->getOption('minimum-execution-time'),
                'timeout'                => $input->getOption('timeout')
            ));
    }
}
