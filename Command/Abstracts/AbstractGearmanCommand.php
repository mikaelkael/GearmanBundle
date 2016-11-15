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

namespace Mkk\GearmanBundle\Command\Abstracts;

use Symfony\Component\Console\Command\Command;

/**
 * Class AbstractGearmanCommand
 */
abstract class AbstractGearmanCommand extends Command
{
    /**
     * @var string
     *
     * Environment
     */
    protected $environment;

    /**
     * Set environment
     *
     * @param string $environment Environment
     *
     * @return AbstractGearmanCommand self Object
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
        return $this;
    }
}
