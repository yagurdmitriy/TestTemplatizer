<?php

namespace TestTemplatizer\Parser\Handlers;
use TestTemplatizer\Parser\Parser\AbstractParser;
use TestTemplatizer\Parser\Scanner\Scanner;

/**
 * Class BooleanAndHandler
 * @package TestTemplatizer\Parser\Handlers
 */
class BooleanAndHandler implements HandlerInterface
{
    /**
     * {@inheritDoc}
     */
    public function handleMatch(AbstractParser $parser, Scanner $scanner)
    {
        $comp1 = $scanner->getContext()->popResult();
        $comp2 = $scanner->getContext()->popResult();

        $scanner->getContext()->pushResult(new BooleanAndExpression($comp1, $comp2));
    }
}