<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 26.06.2017
 * Time: 2:57
 */

namespace TestTemplatizer\Parser;


use TestTemplatizer\Interpreter\AbstractExpression;
use TestTemplatizer\Interpreter\Expressions\VariableExpression;
use TestTemplatizer\Interpreter\InterpreterContext;
use TestTemplatizer\Parser\Handlers\BooleanAndHandler;
use TestTemplatizer\Parser\Handlers\BooleanOrHandler;
use TestTemplatizer\Parser\Handlers\EqualsHandler;
use TestTemplatizer\Parser\Handlers\HtmlHandler;
use TestTemplatizer\Parser\Handlers\IfHandlers\ElseHandler;
use TestTemplatizer\Parser\Handlers\IfHandlers\ThenHandler;
use TestTemplatizer\Parser\Handlers\IfVariableHandler;
use TestTemplatizer\Parser\Handlers\StringLiteralHandler;
use TestTemplatizer\Parser\Handlers\VariableHandler;
use TestTemplatizer\Parser\Parser\AbstractParser;
use TestTemplatizer\Parser\Parser\BraceCloseParser;
use TestTemplatizer\Parser\Parser\BraceOpenParser;
use TestTemplatizer\Parser\Parser\CharacterParser;
use TestTemplatizer\Parser\Parser\CollectionParser\AlternationParser;
use TestTemplatizer\Parser\Parser\CollectionParser\RepetitionParse;
use TestTemplatizer\Parser\Parser\CollectionParser\RepetitionParser;
use TestTemplatizer\Parser\Parser\CollectionParser\SequenceParser;
use TestTemplatizer\Parser\Parser\CollectionParser\ThenParser;
use TestTemplatizer\Parser\Parser\HtmlParser;
use TestTemplatizer\Parser\Parser\IfParser;
use TestTemplatizer\Parser\Parser\StringLiteralParser;
use TestTemplatizer\Parser\Parser\WordParser;
use TestTemplatizer\Parser\Reader\StringReader;
use TestTemplatizer\Parser\Scanner\Scanner;

class MarkParser
{
    private $expression;
    private $operand;
    /** @var  AbstractExpression */
    private $interpreter;
    private $context;

    public function __construct($statement)
    {
        $this->compile($statement);
    }


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

    public function compile($statementStr)
    {
        $scanner  = new Scanner(new StringReader($statementStr), new Context());
        $statement = $this->expression();
        $scanResult = $statement->scan($scanner);

        if (!$scanResult || $scanner->tokenType() != Scanner::EOF) {
            throw new \Exception('parse error');
        }


//        var_dump($scanner->getContext()->resultStack);
//        var_dump($scanner->getContext()->list);

        $this->interpreter = $scanner->getContext()->list;
    }

    public function expression()
    {
        if(!isset($this->expression)) {

            $this->expression = new RepetitionParser(0, 1000000);

            $alternate = new AlternationParser();
            $alternate->add(new HtmlParser())->setHandler(new HtmlHandler());
            $alternate->add($this->variable());
            $alternate->add($this->ifExpr());

            $this->expression->add($alternate);


//            $this->expression = new SequenceParser();
//            $this->expression->add($this->operand());
//            $bools = new RepetitionParser();
//            $whichBool = new AlternationParser();
//            $whichBool->add($this->orExpr());
//            $whichBool->add($this->andExpr());
//            $bools->add($whichBool);
//            $this->expression->add($bools);
        }

        return $this->expression;
    }

    public function ifExpr()
    {
        $ifExpr = new SequenceParser();

        $ifExprCond = new SequenceParser();
        $ifExprCond->add(new WordParser('{'))->discard();
        $ifExprCond->add(new WordParser('if'))->discard();
        $ifExprCond->add(new WordParser());
        $ifExprCond->add(new WordParser('}'))->discard();
        $ifExprCond->setHandler(new IfVariableHandler());
        $ifExpr->add($ifExprCond);

        $ggg = new SequenceParser();
        $ggg->add($this->expression());
        $ggg->setHandler(new ThenHandler());
        $ifExpr->add($ggg);

//        $rep = new RepetitionParser(0, 1000000);
//        $elseExpr = new SequenceParser();
//        $elseExpr->add(new CharacterParser('{'))->discard();
//        $elseExpr->add(new WordParser('else'))->discard();
//        $elseExpr->add(new CharacterParser('}'))->discard();
//        $elseExpr->add($this->expression())->setHandler(new ElseHandler());
//        $rep->add($elseExpr);

        $closeIfExpr = new SequenceParser();
        $closeIfExpr->add(new CharacterParser('{'))->discard();
        $closeIfExpr->add(new CharacterParser('/'))->discard();
        $closeIfExpr->add(new WordParser('if'))->discard();
        $closeIfExpr->add(new CharacterParser('}'))->discard();

        $ifExpr->add($closeIfExpr);


        return $ifExpr;

    }

//    /**
//     * @return AbstractParser
//     */
//    public function html()
//    {
//        $rep = new RepetitionParser();
//        $rep->add(new HtmlParser())->setHandler(new HtmlHandler());
//
//        return $rep;
//    }

//    public function orExpr()
//    {
//        $or = new SequenceParser();
//        $or->add(new WordParser('or'))->discard();
//        $or->add($this->operand());
//        $or->setHandler(new BooleanOrHandler());
//
//        return $or;
//    }

//    public function andExpr()
//    {
//        $and = new SequenceParser();
//        $and->add(new WordParser('and'))->discard();
//        $and->add($this->operand());
//        $and->setHandler(new BooleanAndHandler());
//
//        return $and;
//    }

//    public function operand()
//    {
//        if(!isset($this->operand)) {
//            $this->operand = new SequenceParser();
//
//
//
//
//
//
//            $comp = new AlternationParser();
//            $expr = new SequenceParser();
//            $expr->add(new CharacterParser('('))->discard();
//            $expr->add($this->expression());
//            $expr->add(new CharacterParser(')'))->discard();
//            $comp->add($expr);
//            $comp->add(new StringLiteralParser())->setHandler(new StringLiteralHandler());
//            $comp->add($this->variable());
//            $this->operand->add($comp);
//            $this->operand->add(new RepetitionParse())->add($this->eqExpr());
//        }
//
//        return $this->operand;
//    }
//
//    public function eqExpr()
//    {
//        $equals =  new SequenceParser();
//        $equals->add(new WordParser('equals'))->discard();
//        $equals->add($this->operand());
//        $equals->setHandler(new EqualsHandler());
//
//        return $equals;
//    }

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