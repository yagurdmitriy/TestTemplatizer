<?php

namespace TestTemplatizer\Parser\Parser;

use TestTemplatizer\Parser\Scanner\Scanner;

/**
 * Class WordParser
 * @package TestTemplatizer\Parser\Parser
 */
class HtmlParser extends AbstractParser
{
    /**
     * {@inheritDoc}
     */
    public function trigger(Scanner $scanner)
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    protected function doScan(Scanner $scanner)
    {
       return $this->trigger($scanner);
    }
}