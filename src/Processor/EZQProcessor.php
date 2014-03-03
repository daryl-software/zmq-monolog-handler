<?php

namespace Prelinker\Monolog\Processor;

class EZQProcessor
{

    private $prefix;

    public function __construct($prefix)
    {
        $this->prefix = $prefix;
    }

    public function __invoke(array $record)
    {
        $record['channel'] = sprintf('%s/%s', $this->prefix, $record['channel']);
        return $record;
    }
}
