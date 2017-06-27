<?php

namespace TestTemplatizer\Parser\Handlers\IfHandlers;

use TestTemplatizer\Interpreter\IterableExpressions\ListExpression;
use TestTemplatizer\Interpreter\Operators\ToBoolExpression;
use TestTemplatizer\Interpreter\Statements\IfConditionalStatementExpression;
use TestTemplatizer\Parser\Handlers\HandlerInterface;
use TestTemplatizer\Parser\Parser\AbstractParser;
use TestTemplatizer\Parser\Scanner\Scanner;

class ElseHandler extends AbstractIfHandler
{
    public function handleMatch(AbstractParser $parser, Scanner $scanner)
    {
//        /** @var  $variable */
//        $variable = $scanner->getContext()->getExpression($this->variableParser->getWord());
//        $value = $scanner->getContext()->popResult();
//        $expr = new IfConditionalStatementExpression(
//            new ToBoolExpression($variable),
//            new ListExpression([new LiteralExpression($value)])
//        );
//        $scanner->getContext()->list->add($expr);

    }
}