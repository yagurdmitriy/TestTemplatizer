<?php

namespace TestTemplatizer\Parser\Handlers\IfHandlers;

use TestTemplatizer\Interpreter\Expressions\LiteralExpression;
use TestTemplatizer\Interpreter\IterableExpressions\ListExpression;
use TestTemplatizer\Interpreter\Operators\ToBoolExpression;
use TestTemplatizer\Interpreter\Statements\IfConditionalStatementExpression;
use TestTemplatizer\Parser\Handlers\HandlerInterface;
use TestTemplatizer\Parser\Parser\AbstractParser;
use TestTemplatizer\Parser\Scanner\Scanner;

class ThenHandler extends AbstractIfHandler
{
    public function handleMatch(AbstractParser $parser, Scanner $scanner)
    {
//        var_dump($scanner->getContext()->list);
        /** @var  $variable */
        $variable = $scanner->getContext()->getExpression($scanner->getContext()->popResult());





        $value = $scanner->getContext()->popResult();
        $expr = new IfConditionalStatementExpression(
            new ToBoolExpression($variable),
            new ListExpression([new LiteralExpression($value)])
        );
        $scanner->getContext()->list->add($expr);
    }

}