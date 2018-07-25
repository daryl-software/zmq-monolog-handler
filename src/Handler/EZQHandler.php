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
use Prelinker\Monolog\Formatter\EZQFormatter;

class EZQHandler extends ZMQHandler
{
    /**
     * @param string        $dsn        ZMQ DSN
     * @param int           $level
     * @param bool          $bubble     Whether the messages that are handled can bubble up the stack or not
     */
    public function __construct($dsn, $level = Logger::DEBUG, $bubble = true)
    {
        $zmqsocket = new \ZMQSocket(new \ZMQContext(), \ZMQ::SOCKET_PUSH, 'MonologEZQSocketHandler');
        $zmqsocket->setSockOpt(\ZMQ::SOCKOPT_LINGER, 1000);
        $zmqsocket->connect($dsn);

        parent::__construct($zmqsocket, $level, $bubble);
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
        return new EZQFormatter();
    }
}
