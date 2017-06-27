<?php

namespace TestTemplatizer\Parser\Handlers;


use TestTemplatizer\Interpreter\Expressions\VariableExpression;
use TestTemplatizer\Parser\Parser\AbstractParser;
use TestTemplatizer\Parser\Scanner\Scanner;

class VariableHandler implements HandlerInterface
{
    /**
     * {@inheritDoc}
     */
    public function handleMatch(AbstractParser $parser, Scanner $scanner)
    {
        $expr = new VariableExpression($scanner->getContext()->popResult());
        $scanner->getContext()->list->add($expr);
    }
}
