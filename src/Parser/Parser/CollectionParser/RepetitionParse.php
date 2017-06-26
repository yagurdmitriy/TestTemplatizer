<?php

namespace TestTemplatizer\Parser\Parser\CollectionParser;

use TestTemplatizer\Parser\Parser\AbstractParser;
use TestTemplatizer\Parser\Scanner\Scanner;

/**
 * Class RepetitionParse
 * @package TestTemplatizer\Parser\Parser\CollectionParser
 */
class RepetitionParse extends AbstractCollectionParser
{
    private $min;
    private $max;

    /**
     * RepetitionParse constructor.
     * @param int    $min
     * @param int    $max
     * @param string $name
     * @param array  $options
     * @throws \Exception
     */
    public function __construct($min, $max, $name=null, $options=null)
    {
        parent::__construct($name, $options);
        if($max < $min && $max > 0) {
            throw new \Exception('$max < $min && $max > 0');
        }
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * @param Scanner $scanner
     * @return bool
     */
    public function trigger(Scanner $scanner)
    {
       return true;
    }

    /**
     * @param Scanner $scanner
     * @return bool
     */
    protected function doScan(Scanner $scanner)
    {
        $startState = $scanner->getState();
        if(empty($this->parsers)) {
            return true;
        }
        /** @var AbstractParser $parser */
        $parser = $this->parsers[0];
        $count = 0;

        while (true) {
            if ($this->max > 0 && $count >= $this->max) {
                return true;
            }

            if(!$parser->trigger($scanner)) {
                if($this->min ==0 || $count > $this->min) {
                    return true;
                } else {
                    $scanner->setState($startState);
                }
            }

            if (!$parser->scan($scanner)) {
                if($this->min ==0 || $count > $this->min) {
                    return true;
                } else {
                    $scanner->setState($startState);
                }
            }
            $count++;
        }
        return true;
    }
}