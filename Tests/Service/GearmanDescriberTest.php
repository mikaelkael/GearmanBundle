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

namespace Mkk\GearmanBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Tests GearmanDescriber class
 */
class GearmanDescriberTest extends WebTestCase
{

    /**
     * Test service can be instanced through container
     */
    public function testGearmanDescriberLoadFromContainer()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $this->assertInstanceOf(
            '\Mkk\GearmanBundle\Service\GearmanDescriber',
            static::$kernel
                ->getContainer()
                ->get('gearman.describer')
        );
    }
}
