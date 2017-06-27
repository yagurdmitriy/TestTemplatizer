<?php

namespace TestTemplatizer\Parser\Parser\CollectionParser;

use TestTemplatizer\Parser\Scanner\Scanner;

/**
 * Class AlternationParse
 * @package TestTemplatizer\Parser\Parser\CollectionParser
 */
class AlternationParser extends AbstractCollectionParser
{
    /**
     * {@inheritDoc}
     */
    public function trigger(Scanner $scanner)
    {
        foreach ($this->parsers as $parser) {
            if($parser->trigger($scanner)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    protected function doScan(Scanner $scanner)
    {
        $type = $scanner->tokenType();
        foreach ($this->parsers as $parser) {
            $startState = $scanner->getState();
            if($type == $parser->trigger($scanner) && $parser->scan($scanner)){
                return true;
            }
        }
        $scanner->setState($startState);

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function term()
    {
        return false;
    }
}
