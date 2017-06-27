<?php

namespace TestTemplatizer\Parser\Parser\CollectionParser;

use TestTemplatizer\Parser\Parser\AbstractParser;
use TestTemplatizer\Parser\Scanner\Scanner;

/**
 * Class SequenceParser
 * @package TestTemplatizer\Parser\Parser\CollectionParser
 */
class SequenceParser extends AbstractCollectionParser
{
    /**
     * @param Scanner $scanner
     * @return bool|mixed
     */
    public function trigger(Scanner $scanner)
    {
        if (empty($this->parsers)) {
            return false;
        }

        /** @var AbstractParser $parser */
        $parser = $this->parsers[0];

        return $parser->trigger($scanner);
    }

    /**
     * @param Scanner $scanner
     * @return bool
     */
    protected function doScan(Scanner $scanner)
    {
       $startState = $scanner->getState();
        var_dump('squence parser ->>>');
        foreach ($this->parsers as $parser) {
            var_dump($parser->name);
        }
        foreach ($this->parsers as $parser) {
            /** @var AbstractParser $parser */
                $var = !($parser->trigger($scanner) && $scan = $parser->scan($scanner));
                var_dump($parser->name);
            if($var){
                var_dump('squence parser false');
                $scanner->setState($startState);
                return false;
            }
       }
        var_dump('<<<- squence parser ');
       return true;
    }

    /**
     * @return bool
     */
    public function term()
    {
        return false;
    }
}