**Example**

$context = new \TestTemplatizer\Parser\Context();
$userIn = "
    <div>{my_var}</div>
<div>
    {if bool_var}
        {if bool_var}
            dsdfs
        {/if}
    {else}
        bool_var is False
    {/if}
</div>";

$reader = new \TestTemplatizer\Parser\Reader\StringReader($userIn);
$scanner = new \TestTemplatizer\Parser\Scanner\Scanner($reader, $context);
echo "<table>";

while ($scanner->nextToken() != \TestTemplatizer\Parser\Scanner\Scanner::EOF) {
    echo "<tr>";
    echo "<td>{$scanner->token()}</td>";
    echo "<td>{$scanner->charNumber()}</td>";
    echo "<td>{$scanner->getTypeString()}</td>";
}
echo "</table>";




--------------------------------------



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