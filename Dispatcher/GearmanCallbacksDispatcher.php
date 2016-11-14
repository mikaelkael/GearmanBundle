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

namespace Mkk\GearmanBundle\Dispatcher;

use GearmanTask;
use Mkk\GearmanBundle\Dispatcher\Abstracts\AbstractGearmanDispatcher;
use Mkk\GearmanBundle\Event\GearmanClientCallbackCompleteEvent;
use Mkk\GearmanBundle\Event\GearmanClientCallbackCreatedEvent;
use Mkk\GearmanBundle\Event\GearmanClientCallbackDataEvent;
use Mkk\GearmanBundle\Event\GearmanClientCallbackExceptionEvent;
use Mkk\GearmanBundle\Event\GearmanClientCallbackFailEvent;
use Mkk\GearmanBundle\Event\GearmanClientCallbackStatusEvent;
use Mkk\GearmanBundle\Event\GearmanClientCallbackWarningEvent;
use Mkk\GearmanBundle\Event\GearmanClientCallbackWorkloadEvent;
use Mkk\GearmanBundle\GearmanEvents;

/**
 * Gearman callbacks
 */
class GearmanCallbacksDispatcher extends AbstractGearmanDispatcher
{
    /**
     * Assign all GearmanClient callbacks as Symfony2 events
     *
     * @param \GearmanClient $gearmanClient Gearman client
     *
     * @return GearmanCallbacksDispatcher self Object
     */
    public function assignTaskCallbacks(\GearmanClient $gearmanClient)
    {
        $gearmanClient->setCompleteCallback(array(
            $this,
            'assignCompleteCallback'
        ));

        $gearmanClient->setFailCallback(array(
            $this,
            'assignFailCallback'
        ));

        $gearmanClient->setDataCallback(array(
            $this,
            'assignDataCallback'
        ));

        $gearmanClient->setCreatedCallback(array(
            $this,
            'assignCreatedCallback'
        ));

        $gearmanClient->setExceptionCallback(array(
            $this,
            'assignExceptionCallback'
        ));

        $gearmanClient->setStatusCallback(array(
            $this,
            'assignStatusCallback'
        ));

        $gearmanClient->setWarningCallback(array(
            $this,
            'assignWarningCallback'
        ));

        $gearmanClient->setWorkloadCallback(array(
            $this,
            'assignWorkloadCallback'
        ));
    }

    /**
     * Assigns CompleteCallback into GearmanTask
     *
     * @param GearmanTask $gearmanTask Gearman Task
     *
     * @see http://www.php.net/manual/en/gearmanclient.setcompletecallback.php
     */
    public function assignCompleteCallback(GearmanTask $gearmanTask, $contextReference = null)
    {
        $event = new GearmanClientCallbackCompleteEvent($gearmanTask);
        if (!is_null($contextReference)) {
            $event->setContext($contextReference);
        }
        $this->eventDispatcher->dispatch(
            GearmanEvents::GEARMAN_CLIENT_CALLBACK_COMPLETE,
            $event
        );
    }

    /**
     * Assigns FailCallback into GearmanTask
     *
     * @param GearmanTask $gearmanTask Gearman Task
     *
     * @see http://www.php.net/manual/en/gearmanclient.setfailcallback.php
     */
    public function assignFailCallback(GearmanTask $gearmanTask)
    {
        $event = new GearmanClientCallbackFailEvent($gearmanTask);
        $this->eventDispatcher->dispatch(
            GearmanEvents::GEARMAN_CLIENT_CALLBACK_FAIL,
            $event
        );
    }

    /**
     * Assigns DataCallback into GearmanTask
     *
     * @param GearmanTask $gearmanTask Gearman Task
     *
     * @see http://www.php.net/manual/en/gearmanclient.setdatacallback.php
     */
    public function assignDataCallback(GearmanTask $gearmanTask)
    {
        $event = new GearmanClientCallbackDataEvent($gearmanTask);
        $this->eventDispatcher->dispatch(
            GearmanEvents::GEARMAN_CLIENT_CALLBACK_DATA,
            $event
        );
    }

    /**
     * Assigns CreatedCallback into GearmanTask
     *
     * @param GearmanTask $gearmanTask Gearman task
     *
     * @see http://www.php.net/manual/en/gearmanclient.setcreatedcallback.php
     */
    public function assignCreatedCallback(GearmanTask $gearmanTask)
    {
        $event = new GearmanClientCallbackCreatedEvent($gearmanTask);
        $this->eventDispatcher->dispatch(
            GearmanEvents::GEARMAN_CLIENT_CALLBACK_CREATED,
            $event
        );
    }

    /**
     * Assigns ExceptionCallback into GearmanTask
     *
     * @see http://www.php.net/manual/en/gearmanclient.setexceptioncallback.php
     */
    public function assignExceptionCallback(GearmanTask $gearmanTask)
    {
        $event = new GearmanClientCallbackExceptionEvent($gearmanTask);
        $this->eventDispatcher->dispatch(
            GearmanEvents::GEARMAN_CLIENT_CALLBACK_EXCEPTION,
            $event
        );
    }

    /**
     * Assigns StatusCallback into GearmanTask
     *
     * @param GearmanTask $gearmanTask Gearman Task
     *
     * @see http://www.php.net/manual/en/gearmanclient.setstatuscallback.php
     */
    public function assignStatusCallback(GearmanTask $gearmanTask)
    {
        $event = new GearmanClientCallbackStatusEvent($gearmanTask);
        $this->eventDispatcher->dispatch(
            GearmanEvents::GEARMAN_CLIENT_CALLBACK_STATUS,
            $event
        );
    }

    /**
     * Assigns WarningCallback into GearmanTask
     *
     * @param GearmanTask $gearmanTask Gearman Task
     *
     * @see http://www.php.net/manual/en/gearmanclient.setwarningcallback.php
     */
    public function assignWarningCallback(GearmanTask $gearmanTask)
    {
        $event = new GearmanClientCallbackWarningEvent($gearmanTask);
        $this->eventDispatcher->dispatch(
            GearmanEvents::GEARMAN_CLIENT_CALLBACK_WARNING,
            $event
        );
    }

    /**
     * Assigns WorkloadCallback into GearmanTask
     *
     * @param GearmanTask $gearmanTask Gearman Task
     *
     * @see http://www.php.net/manual/en/gearmanclient.setworkloadcallback.php
     */
    public function assignWorkloadCallback(GearmanTask $gearmanTask)
    {
        $event = new GearmanClientCallbackWorkloadEvent($gearmanTask);
        $this->eventDispatcher->dispatch(
            GearmanEvents::GEARMAN_CLIENT_CALLBACK_WORKLOAD,
            $event
        );
    }
}
