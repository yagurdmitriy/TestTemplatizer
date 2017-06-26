<?php

namespace TestTemplatizer\Parser\Parser;

use TestTemplatizer\Parser\Scanner\Scanner;

/**
 * Class WordParser
 * @package TestTemplatizer\Parser\Parser
 */
class WordParser extends AbstractParser
{
    protected $word;

    /**
     * WordParser constructor.
     * @param string $word
     * @param string $name
     * @param array  $options
     */
    public function __construct($word = null, $name = null, $options = null)
    {
        parent::__construct($name, $options);
        $this->word = $word;
    }

    /**
     * @param Scanner $scanner
     * @return bool
     */
    public function trigger(Scanner $scanner)
    {
        if($scanner->tokenType() != Scanner::WORD) {
            return false;
        }

        if(is_null($this->word)) {
            return true;
        }

        return $this->word == $scanner->token();
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