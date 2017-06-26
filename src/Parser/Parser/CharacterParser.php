<?php

namespace TestTemplatizer\Parser\Parser;

use TestTemplatizer\Parser\Scanner\Scanner;

/**
 * Class CharacterParser
 * @package TestTemplatizer\Parser\Parser
 */
class CharacterParser extends AbstractParser
{
    private $char;

    /**
     * CharacterParser constructor.
     * @param string $char
     * @param string $name
     * @param array  $options
     */
    public function __construct($char, $name = null, $options = null)
    {
        parent::__construct($name, $options);
        $this->char = $char;
    }

    /**
     * @param Scanner $scanner
     * @return bool
     */
    public function trigger(Scanner $scanner)
    {
        return $scanner->token() == $this->char;
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