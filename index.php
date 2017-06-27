<?php
require_once "C:\\HOSTS\\test-task\\vendor\\autoload.php";


$userIn = "
    <div>{my_var</div>

    <div>dfgdsgsdgfsdfgsdf</div>
    <div>{my_var1}</div>
    <div>{my_var2}</div>
    <div>{my_var3}</div>
";

$engine = new \TestTemplatizer\Parser\MarkParser($userIn);
$result = $engine->evaluate([
    ['name' => 'my_var', 'value' => '1'],
    ['name' => 'my_var1', 'value' => '2'],
    ['name' => 'my_var2', 'value' => '3'],
    ['name' => 'my_var3', 'value' => '4'],
    ['name' => 'my_var4', 'value' => false],
]);

echo $result;
