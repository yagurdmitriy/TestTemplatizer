<?php

namespace TestTemplatizer\Parser\Handlers;

use TestTemplatizer\Interpreter\Expressions\LiteralExpression;
use TestTemplatizer\Parser\Parser\AbstractParser;
use TestTemplatizer\Parser\Scanner\Scanner;

/**
 * Class HtmlHandler
 * @package TestTemplatizer\Parser\Handlers
 */
class HtmlHandler implements HandlerInterface
{
    /**
     * {@inheritDoc}
     */
    public function handleMatch(AbstractParser $parser, Scanner $scanner)
    {
        $value = $scanner->getContext()->popResult();
        $expr = new LiteralExpression($value);
//        $scanner->getContext()->pushResult($expr);
        $scanner->getContext()->list->add($expr);
    }
}