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
     * @param Scanner $scanner
     * @return bool
     */
    public function trigger(Scanner $scanner)
    {
        if($scanner->tokenType() == Scanner::WORD
            || $scanner->tokenType() == Scanner::CHAR
            || $scanner->tokenType() == Scanner::EOL
            || $scanner->tokenType() == Scanner::WHITESPACE
            || $scanner->tokenType() == Scanner::BRACE_OPEN
            || $scanner->tokenType() == Scanner::BRACE_CLOSE
        ) {
            return true;
        }

        return false;
    }

    /**
     * @param Scanner $scanner
     * @return bool
     */
    protected function doScan(Scanner $scanner)
    {
       return $this->trigger($scanner);
    }
}