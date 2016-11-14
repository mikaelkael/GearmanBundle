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

namespace Mkk\GearmanBundle\Command\Util;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Interface GearmanOutputAwareInterface
 *
 * @author Dominic Grostate <codekestrel@googlemail.com>
 */
interface GearmanOutputAwareInterface
{
    /**
     * Set the output
     *
     * @param OutputInterface $output
     */
    public function setOutput(OutputInterface $output);
}
