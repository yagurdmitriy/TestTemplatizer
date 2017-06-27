<?php

namespace TestTemplatizer\Parser\Handlers;

use TestTemplatizer\Parser\Parser\AbstractParser;
use TestTemplatizer\Parser\Scanner\Scanner;

/**
 * Interface HandlerInterface
 * @package TestTemplatizer\Parser\Handlers
 */
interface HandlerInterface
{
    /**
     * @param AbstractParser $parser
     * @param Scanner $scanner
     * @return mixed
     */
    public function handleMatch(AbstractParser $parser, Scanner $scanner);
}