<?php

namespace TestTemplatizer\Parser\Parser;


use TestTemplatizer\Parser\Scanner\Scanner;

class BraceCloseParser extends AbstractParser
{
    /**
     * @param Scanner $scanner
     * @return bool
     */
    public function trigger(Scanner $scanner)
    {
        if($scanner->tokenType() == Scanner::BRACE_CLOSE) {
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

    /**
     * @return bool
     */
    public function term()
    {
        return false;
    }

}