<?php

namespace TestTemplatizer\Parser\Parser;

use TestTemplatizer\Parser\Scanner\Scanner;

/**
 * Class StringLiteralParse
 * @package TestTemplatizer\Parser\Parser\CollectionParser
 */
class StringLiteralParse extends AbstractParser
{
    /**
     * @param Scanner $scanner
     * @return bool
     */
    public function trigger(Scanner $scanner)
    {
        return $scanner->tokenType() == Scanner::APOS || $scanner->tokenType() == Scanner::QUOTE;
    }

    /**
     * @param Scanner $scanner
     * $return null
     */
    protected function push(Scanner $scanner)
    {
        return;
    }

    /**
     * @param Scanner $scanner
     * @return bool
     */
    protected function doScan(Scanner $scanner)
    {
        $quoteChar = $scanner->tokenType();
        $ret = false;
        $string = "";
        while($token = $scanner->nextToken()) {
            if($token == $quoteChar) {
                $ret = true;
                break;
            }
            $string .= $scanner->token();
        }
        if($string && !$this->discard) {
            $scanner->getContext()->pushResult($string);
        }
        return $ret;
    }
}