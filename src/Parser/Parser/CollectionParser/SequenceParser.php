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
     * {@inheritDoc}
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
     * {@inheritDoc}
     */
    protected function doScan(Scanner $scanner)
    {
       $startState = $scanner->getState();
        foreach ($this->parsers as $parser) {
            /** @var AbstractParser $parser */
            if(!($parser->trigger($scanner) && $scan = $parser->scan($scanner))){
                $scanner->setState($startState);

                return false;
            }
       }
       return true;
    }

    /**
     * {@inheritDoc}
     */
    public function term()
    {
        return false;
    }
}
