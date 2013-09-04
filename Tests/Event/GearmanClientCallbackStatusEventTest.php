<?php

/**
 * RSQueueBundle for Symfony2
 *
 * Marc Morera 2013
 */

namespace Mmoreram\GearmanBundle\Tests\Event;

use Mmoreram\GearmanBundle\Event\GearmanClientCallbackStatusEvent;

/**
 * Tests GearmanClientCallbackStatusEventTest class
 */
class GearmanClientCallbackStatusEventTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var GearmanClientCallbackStatusEvent
     *
     * Object to test
     */
    private $gearmanClientCallbackStatusEvent;


    /**
     * @var array
     *
     * Payload for testing
     */
    private $gearmanTask;


    /**
     * Setup
     */
    public function setUp()
    {

        $this->gearmanTask = $this->getMock('\GearmanTask');
        $this->gearmanClientCallbackStatusEvent = new GearmanClientCallbackStatusEvent($this->gearmanTask);
    }


    /**
     * Testing payload getter
     */
    public function testGetGearmanTask()
    {
        $this->assertEquals($this->gearmanClientCallbackStatusEvent->getGearmanTask(), $this->gearmanTask);
    }
}