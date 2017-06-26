<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 26.06.2017
 * Time: 2:57
 */

namespace TestTemplatizer\Parser;


use TestTemplatizer\Interpreter\Expressions\VariableExpression;
use TestTemplatizer\Interpreter\InterpreterContext;
use TestTemplatizer\Parser\Parser\CharacterParser;
use TestTemplatizer\Parser\Parser\CollectionParser\AlternationParse;
use TestTemplatizer\Parser\Parser\CollectionParser\RepetitionParse;
use TestTemplatizer\Parser\Parser\CollectionParser\SequenceParser;
use TestTemplatizer\Parser\Parser\StringLiteralParse;
use TestTemplatizer\Parser\Parser\WordParser;
use TestTemplatizer\Parser\Reader\StringReader;
use TestTemplatizer\Parser\Scanner\Scanner;

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


    function evaluate($input)
    {
        $iСontext = new InterpreterContext();
        $prefab = new VariableExpression('input', $input);
        $prefab->interpret($iСontext);
        $this->interpreter->interpret($iСontext);
        $result = $iСontext->lookup($this->interpreter);

        return $result;
    }

    public function compile($statementStr)
    {
        $context = new Context();
        $scanner  = new Scanner(
            new StringReader($statementStr),
            $context
        );
        $statement = $this->expression();
        $scanResult = $statement->scan($scanner);

        if (!$scanResult || $scanner->tokenType() != Scanner::EOF) {
            throw new \Exception('parse error');
        }

        $this->interpreter = $scanner->getContext()->popResult();
    }

    public function expression()
    {
        if(!isset($this->expression)) {
            $this->expression = new SequenceParser();
            $this->expression->add($this->operand);
            $bools = new RepetitionParse();
            $whichBool = new AlternationParse();
            $whichBool->add($this->orExpr());
            $whichBool->add($this->andExpr());
            $bools->add($whichBool);
            $this->expression->add($bools);
        }

        return $this->expression;
    }

    public function orExpr()
    {
        $or = new SequenceParser();
        $or->add(new WordParser('or'))->discard();
        $or->add($this->operand());
        $or->setHandler(new BooleanOrHandler());

        return $or;
    }

    public function andExpr()
    {
        $and = new SequenceParser();
        $and->add(new WordParser('and'))->discard();
        $and->add($this->operand());
        $and->setHandler(new BooleanAndHandler());

        return $and;
    }

    public function operand()
    {
        if(!isset($this->operand)) {
            $this->operand = new SequenceParser();
            $comp = new AlternationParse();
            $expr = new SequenceParser();
            $expr->add(new CharacterParser('('))->discard();
            $expr->add($this->expression());
            $expr->add(new CharacterParser(')'))->discard();
            $comp->add($expr);
            $comp->add(new StringLiteralParse())->setHandler(new StringLiteralHandler());
            $this->operand->add($comp);
            $this->operand->add(new RepetitionParse())->add($this->eqExpr());
        }
    }

    public function eqExpr()
    {
        $equals =  new SequenceParser();
        $equals->add(new WordParser('equals'))->discard();
        $equals->add($this->operand());
        $equals->setHandler(new EqualsHandler());

        return $equals;
    }

    public function variable()
    {
        $variable = new SequenceParser();
        $variable->add(new WordParser('$'))->discard();
        $variable->add(new WordParser());
        $variable->setHandler(new VariableHandler());

        return $variable;
    }

}