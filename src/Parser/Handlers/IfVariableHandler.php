<?php

namespace TestTemplatizer\Parser\Handlers;


use TestTemplatizer\Interpreter\Expressions\VariableExpression;
use TestTemplatizer\Parser\Parser\AbstractParser;
use TestTemplatizer\Parser\Scanner\Scanner;

class IfVariableHandler implements HandlerInterface
{
    /**
     * {@inheritDoc}
     */
    public function handleMatch(AbstractParser $parser, Scanner $scanner)
    {

        $varName = $scanner->getContext()->popResult();
        var_dump('rrr');
        var_dump($varName);
        $expr = new VariableExpression($varName);
//        $scanner->getContext()->pushResult($varName);
        $scanner->getContext()->list->add($expr);

        return $varName;
    }
}