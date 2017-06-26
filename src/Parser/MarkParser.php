<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 26.06.2017
 * Time: 2:57
 */

namespace TestTemplatizer\Parser;


class MarkParser
{
    private $expression;
    private $operand;
    private $interpreter;
    private $context;

    public function __construct($statement)
    {
        $this->complile($statement);
    }

    function evaluate($input) {

    }

    public function compile($statementStr) {

    }

}