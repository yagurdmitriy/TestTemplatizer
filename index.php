<?php
require_once "C:\\HOSTS\\test-task\\vendor\\autoload.php";


//$userIn = "
//    <div>{my_var}</div>
//
//
//    {if my_var4}
//    <div>dfgdsgsdgfsdfgsdf</div>
//    {/if}
//
//
//    <div>{my_var1}</div>
//    <div>{my_var2}</div>
//    <div>{my_var3}</div>
//";
//
$userIn = "{if my_var4}<div>JKKK</div>{/if}";


$engine = new \TestTemplatizer\Parser\MarkParser($userIn);
$result = $engine->evaluate([
    ['name' => 'my_var', 'value' => '1'],
    ['name' => 'my_var1', 'value' => '2'],
    ['name' => 'my_var2', 'value' => '3'],
    ['name' => 'my_var3', 'value' => '4'],
    ['name' => 'my_var4', 'value' => false],
]);

echo $result;




//$context = new \TestTemplatizer\Parser\Context();
//$userIn = "\$input equals '4' or \$input equals 'four'";
//
//$userIn = "
//    <div>{my_var}</div>
//<div>
//    {if bool_var}
//        {if bool_var}
//            dsdfs
//        {/if}
//    {else}
//        bool_var is False
//    {/if}
//</div>";
//
//$reader = new \TestTemplatizer\Parser\Reader\StringReader($userIn);
//$scanner = new \TestTemplatizer\Parser\Scanner\Scanner($reader, $context);
//echo "<table>";
//
//while ($scanner->nextToken() != \TestTemplatizer\Parser\Scanner\Scanner::EOF) {
//    echo "<tr>";
//    echo "<td>{$scanner->token()}</td>";
//    echo "<td>{$scanner->charNumber()}</td>";
//    echo "<td>{$scanner->getTypeString()}</td>";
//}
//echo "</table>";

//$context = new \TestTemplatizer\Interpreter\InterpreterContext();
//$input = new \TestTemplatizer\Interpreter\Expressions\VariableExpression('input');
//$input2 = new \TestTemplatizer\Interpreter\Expressions\VariableExpression('input2');
//
//$statement = new \TestTemplatizer\Interpreter\IterableExpressions\ListExpression([
//    new \TestTemplatizer\Interpreter\IterableExpressions\ListExpression([
//        new \TestTemplatizer\Interpreter\Expressions\LiteralExpression("123t\n"),
//        new \TestTemplatizer\Interpreter\Expressions\LiteralExpression("32\n"),
//        new \TestTemplatizer\Interpreter\Expressions\LiteralExpression("sdfg\n"),
//        new \TestTemplatizer\Interpreter\Expressions\LiteralExpression("4trewr\n"),
//        ]),
//    new \TestTemplatizer\Interpreter\IterableExpressions\ListExpression([]),
//    new \TestTemplatizer\Interpreter\IterableExpressions\ListExpression([
//        new \TestTemplatizer\Interpreter\Expressions\LiteralExpression("sdhgfdfg\n"),
//        new \TestTemplatizer\Interpreter\Expressions\LiteralExpression("dggtryj\n"),
//        new \TestTemplatizer\Interpreter\Expressions\LiteralExpression("sdfjhgfsdg\n"),
//        new \TestTemplatizer\Interpreter\Expressions\LiteralExpression("sdoiuytfg\n"),
//    ]),
//    new \TestTemplatizer\Interpreter\IterableExpressions\ListExpression([]),
//    new \TestTemplatizer\Interpreter\Expressions\LiteralExpression("ttafgsfghtttttttttt\n"),
//]);

//$statement = new \TestTemplatizer\Interpreter\IterableExpressions\ListExpression([
//    new \TestTemplatizer\Interpreter\Statements\IfConditionalStatementExpression(
//        new \TestTemplatizer\Interpreter\Operators\ToBoolExpression($input),
//        new \TestTemplatizer\Interpreter\Statements\IfConditionalStatementExpression(
//            new \TestTemplatizer\Interpreter\Operators\ToBoolExpression($input2),
//            new \TestTemplatizer\Interpreter\IterableExpressions\ListExpression([
//                new \TestTemplatizer\Interpreter\Expressions\LiteralExpression("ttafgsfghtttttttttt\n"),
//                new \TestTemplatizer\Interpreter\Expressions\LiteralExpression('546745674567'),
//                new \TestTemplatizer\Interpreter\Expressions\LiteralExpression('546745674dfghdfghdfghdfghe567'),
//                new \TestTemplatizer\Interpreter\Expressions\LiteralExpression('qqqqqqqqqqqqqqqqqqqqqqqqqqq'),
//                new \TestTemplatizer\Interpreter\Expressions\LiteralExpression('vvvvvvvvvvvvvvvvvvvvvvvvvvvv'),
//            ])
//        ),
//        new \TestTemplatizer\Interpreter\Expressions\LiteralExpression('test2')
//    )
//]);

//$input->setValue(true);
//$input2->setValue(true);
//$statement->interpret($context);
//var_dump($context->lookup($statement));
//
//
//$input->setValue(false);
//$input2->setValue('dsfasd');
//$statement->interpret($context);
//var_dump($context->lookup($statement));

echo "1";
