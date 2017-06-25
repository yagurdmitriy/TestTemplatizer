<?php
require_once "C:\\HOSTS\\test-task\\vendor\\autoload.php";


$context = new \TestTemplatizer\Interpreter\InterpreterContext();
$input = new \TestTemplatizer\Interpreter\Expressions\VariableExpression('input');
$input2 = new \TestTemplatizer\Interpreter\Expressions\VariableExpression('input2');

$statement = new \TestTemplatizer\Interpreter\Statements\IfConditionalStatementExpression(
    new \TestTemplatizer\Interpreter\Operators\ToBoolExpression($input),
    new \TestTemplatizer\Interpreter\Statements\IfConditionalStatementExpression(
        new \TestTemplatizer\Interpreter\Operators\ToBoolExpression($input2),
        new \TestTemplatizer\Interpreter\IterableExpressions\ListExpression([
            new \TestTemplatizer\Interpreter\Expressions\LiteralExpression('ttafgsfghtttttttttt'),
            new \TestTemplatizer\Interpreter\Expressions\LiteralExpression('546745674567'),
            new \TestTemplatizer\Interpreter\Expressions\LiteralExpression('546745674dfghdfghdfghdfghe567'),
            new \TestTemplatizer\Interpreter\Expressions\LiteralExpression('qqqqqqqqqqqqqqqqqqqqqqqqqqq'),
            new \TestTemplatizer\Interpreter\Expressions\LiteralExpression('vvvvvvvvvvvvvvvvvvvvvvvvvvvv'),
        ])
    ),
    new \TestTemplatizer\Interpreter\Expressions\LiteralExpression('test2')
);

$input->setValue(true);
$input2->setValue(true);
$statement->interpret($context);
var_dump($context->lookup($statement));


$input->setValue(false);
$input2->setValue('dsfasd');
$statement->interpret($context);
var_dump($context->lookup($statement));

echo "1";
