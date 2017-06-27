<?php

namespace TestTemplatizer\Parser;

use TestTemplatizer\Interpreter\AbstractExpression;
use TestTemplatizer\Interpreter\Expressions\VariableExpression;
use TestTemplatizer\Interpreter\InterpreterContext;
use TestTemplatizer\Parser\Handlers\HtmlHandler;
use TestTemplatizer\Parser\Handlers\VariableHandler;
use TestTemplatizer\Parser\Parser\AbstractParser;
use TestTemplatizer\Parser\Parser\CharacterParser;
use TestTemplatizer\Parser\Parser\CollectionParser\AlternationParser;
use TestTemplatizer\Parser\Parser\CollectionParser\RepetitionParser;
use TestTemplatizer\Parser\Parser\CollectionParser\SequenceParser;
use TestTemplatizer\Parser\Parser\HtmlParser;
use TestTemplatizer\Parser\Parser\WordParser;
use TestTemplatizer\Parser\Reader\StringReader;
use TestTemplatizer\Parser\Scanner\Scanner;

class MarkParser
{
    /** @var   */
    private $expression;
    /** @var  AbstractExpression */
    private $interpreter;

    public function __construct($statement)
    {
        $this->compile($statement);
    }

    /**
     * @param array $input
     * @return mixed
     */
    function evaluate($input = [])
    {
        $iСontext = new InterpreterContext();

        foreach ($input as $item) {
            $prefab = new VariableExpression($item['name'], $item['value']);
            $prefab->interpret($iСontext);
        }
        $this->interpreter->interpret($iСontext);
        $result = $iСontext->lookup($this->interpreter);

        return $result;
    }

    /**
     * @param $statementStr
     * @throws \Exception
     */
    public function compile($statementStr)
    {
        $scanner  = new Scanner(new StringReader($statementStr), new Context());
        $statement = $this->expression();
        $scanResult = $statement->scan($scanner);

        if (!$scanResult || $scanner->tokenType() != Scanner::EOF) {
            throw new \Exception('parse error');
        }

        $this->interpreter = $scanner->getContext()->list;
    }

    /**
     * @return RepetitionParser
     */
    public function expression()
    {
        if(!isset($this->expression)) {
            $this->expression = new RepetitionParser();
            $alternate = new AlternationParser();
            $alternate->add($this->variable());
            $alternate->add(new HtmlParser())->setHandler(new HtmlHandler());
            $this->expression->add($alternate);
        }

        return $this->expression;
    }

    /**
     * @return SequenceParser
     */
    public function variable()
    {
        $variable = new SequenceParser();
        $variable->add(new CharacterParser('{'))->discard();
        $variable->add(new WordParser());
        $variable->add(new CharacterParser('}'))->discard();
        $variable->setHandler(new VariableHandler());

        return $variable;
    }
}
