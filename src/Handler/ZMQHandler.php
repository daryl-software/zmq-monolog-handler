<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Prelinker\Monolog\Handler;

use Monolog\Logger;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\AbstractProcessingHandler;

class ZMQHandler extends AbstractProcessingHandler
{
    /**
     * @var \ZMQSocket $zmqsocket
     */
    protected $zmqsocket;

    /**
     * @param \ZMQSocket    $zmqsocket     ZMQ socket, ready for use
     * @param int           $level
     * @param bool          $bubble       Whether the messages that are handled can bubble up the stack or not
     */
    public function __construct(\ZMQSocket $zmqsocket, $level = Logger::DEBUG, $bubble = true)
    {
        $this->zmqsocket = $zmqsocket;

        parent::__construct($level, $bubble);
    }

    /**
     * {@inheritDoc}
     */
    protected function write(array $record)
    {
        $this->zmqsocket->send($record["formatted"], \ZMQ::MODE_NOBLOCK);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultFormatter()
    {
        return new JsonFormatter();
    }
}
