<?php
require_once "C:\\HOSTS\\test-task\\vendor\\autoload.php";


$context = new \TestTemplatizer\Interpreter\InterpreterContext();
$input = new \TestTemplatizer\Interpreter\Expressions\VariableExpression('input');
$input2 = new \TestTemplatizer\Interpreter\Expressions\VariableExpression('input2');

$statement = new \TestTemplatizer\Interpreter\Statements\IfConditionalStatementExpression(
    new \TestTemplatizer\Interpreter\Operators\ToBoolExpression($input),
    new \TestTemplatizer\Interpreter\Statements\IfConditionalStatementExpression(
        new \TestTemplatizer\Interpreter\Operators\ToBoolExpression($input2),
        new \TestTemplatizer\Interpreter\Expressions\LiteralExpression('test3')
    ),
    new \TestTemplatizer\Interpreter\Expressions\LiteralExpression('test2')
);

$input->setValue('sdf');
$input2->setValue('1');
$statement->interpret($context);
var_dump($context->lookup($statement));


$input->setValue('ertwetr');
$input2->setValue('dsfasd');
$statement->interpret($context);
var_dump($context->lookup($statement));

echo "1";
