<?php

namespace TestTemplatizer\Parser\Handlers;
use TestTemplatizer\Parser\Parser\AbstractParser;
use TestTemplatizer\Parser\Scanner\Scanner;

/**
 * Class BooleanOrHandler
 * @package TestTemplatizer\Parser\Handlers
 */
class BooleanOrHandler implements HandlerInterface
{
    /**
     * {@inheritDoc}
     */
    public function handleMatch(AbstractParser $parser, Scanner $scanner)
    {
        $comp1 = $scanner->getContext()->popResult();
        $comp2 = $scanner->getContext()->popResult();

        $scanner->getContext()->pushResult(new BooleanOrExpression($comp1, $comp2));
    }
}