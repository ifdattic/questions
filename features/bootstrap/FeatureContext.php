<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Doctrine\ORM\EntityManager;
use PHPUnit_Framework_Assert as Assert;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    /** @var EntityManager */
    private $em;

    /** @var mixed */
    private $result;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @BeforeScenario
     */
    public function clearData()
    {
        $this->em->getRepository('AppBundle:Question')->deleteAll();
    }

    /**
     * @Given there are no questions
     */
    public function thereAreNoQuestions()
    {
        $this->em->getRepository('AppBundle:Question')->deleteAll();
    }

    /**
     * @When I request a list of questions
     */
    public function iRequestAListOfQuestions()
    {
        $this->result = $this->em->getRepository('AppBundle:Question')->getQuestions();
    }

    /**
     * @Then I should see an empty list
     */
    public function iShouldSeeAnEmptyList()
    {
        Assert::assertInternalType('array', $this->result, 'Result should be an array');
        Assert::assertEmpty($this->result);
    }

    /**
     * @Given there is a question :question
     */
    public function thereIsAQuestion($question)
    {
        $this->em->getRepository('AppBundle:Question')->addQuestion(['question' => $question]);
    }

    /**
     * @Then I should see a list of questions containing:
     */
    public function iShouldSeeAListOfQuestionsContaining(TableNode $table)
    {
        $callback = function ($question) {
            return [
                'question' => (string) $question->getQuestion(),
            ];
        };
        $questions = array_map($callback, $this->result);

        Assert::assertEquals($table->getHash(), $questions);
    }
}
