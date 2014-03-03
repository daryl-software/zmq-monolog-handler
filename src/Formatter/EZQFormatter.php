<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Prelinker\Monolog\Formatter;

use Monolog\Formatter\NormalizerFormatter;

/**
 * Encodes whatever record data is passed to it as json
 *
 * This can be useful to log to databases or remote APIs
 *
 * @author Jordi Boggiano <j.boggiano@seld.be>
 */
class EZQFormatter extends NormalizerFormatter
{
    /**
     * {@inheritdoc}
     */
    public function format(array $record)
    {
        if (isset($record['context']['exception'])) {
            $exception = $record['context']['exception'];
            $record['message'] = (string)$exception;
        }

        $ez_formatted = array(
            "type" => "logs",
            "logs" => array(
                "host"     => gethostname(),
                "priority" => $record['level'],
                "level"    => $record['level_name'],
                "datetime" => $record['datetime']->format('Y-m-d H:i:s'),
                "program"  => $record['channel'],
                "msg"      => $record['message']
            )
        );

        return json_encode($ez_formatted);
    }
}
