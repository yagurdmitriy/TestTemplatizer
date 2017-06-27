<?php

namespace TestTemplatizer\Parser\Parser;

use TestTemplatizer\Parser\Scanner\Scanner;

/**
 * Class WordParser
 * @package TestTemplatizer\Parser\Parser
 */
class WordParser extends AbstractParser
{
    /** @var null|string  */
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
    /**
     * {@inheritDoc}
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
     * {@inheritDoc}
     */
    protected function doScan(Scanner $scanner)
    {
       return $this->trigger($scanner);
    }

    /**
     * @return null|string
     */
    public function getWord()
    {
        return $this->word;
    }
}