**Example**

$context = new \TestTemplatizer\Interpreter\InterpreterContext();
$input = new \TestTemplatizer\Interpreter\Expressions\VariableExpression('input');
$input2 = new \TestTemplatizer\Interpreter\Expressions\VariableExpression('input2');

$statement = new \TestTemplatizer\Interpreter\IterableExpressions\ListExpression([
    new \TestTemplatizer\Interpreter\IterableExpressions\ListExpression([
        new \TestTemplatizer\Interpreter\Expressions\LiteralExpression("test1"),
        new \TestTemplatizer\Interpreter\Expressions\LiteralExpression("test2"),
        new \TestTemplatizer\Interpreter\Expressions\LiteralExpression("test3\n"),
        new \TestTemplatizer\Interpreter\Expressions\LiteralExpression("test4\n"),
        ]),
    new \TestTemplatizer\Interpreter\IterableExpressions\ListExpression([]),
    new \TestTemplatizer\Interpreter\IterableExpressions\ListExpression([
        new \TestTemplatizer\Interpreter\Expressions\LiteralExpression("test5\n"),
        new \TestTemplatizer\Interpreter\Expressions\LiteralExpression("test6\n"),
        new \TestTemplatizer\Interpreter\Expressions\LiteralExpression("test7\n"),
        new \TestTemplatizer\Interpreter\Expressions\LiteralExpression("test8\n"),
    ]),
    new \TestTemplatizer\Interpreter\IterableExpressions\ListExpression([]),
    new \TestTemplatizer\Interpreter\Expressions\LiteralExpression("test9\n"),
]);

$statement1 =
    new \TestTemplatizer\Interpreter\Statements\IfConditionalStatementExpression(
        new \TestTemplatizer\Interpreter\Operators\ToBoolExpression($input),
        new \TestTemplatizer\Interpreter\Statements\IfConditionalStatementExpression(
            new \TestTemplatizer\Interpreter\Operators\ToBoolExpression($input2),
            new \TestTemplatizer\Interpreter\IterableExpressions\ListExpression([
                new \TestTemplatizer\Interpreter\Expressions\LiteralExpression("test1\n"),
                new \TestTemplatizer\Interpreter\Expressions\LiteralExpression('test2'),
                new \TestTemplatizer\Interpreter\Expressions\LiteralExpression('test3'),
                new \TestTemplatizer\Interpreter\Expressions\LiteralExpression('test4'),
                new \TestTemplatizer\Interpreter\Expressions\LiteralExpression('test5'),
            ])
        ),
        new \TestTemplatizer\Interpreter\Expressions\LiteralExpression('test6')
    );

$input->setValue(true);
$input2->setValue(true);
$statement->interpret($context);
$statement1->interpret($context);

echo $context->lookup($statement);
echo $context->lookup($statement1);