<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Doctrine\ORM\EntityManager;
use PHPUnit_Framework_Assert as Assert;

class WebContext extends MinkContext implements SnippetAcceptingContext
{
    /** @var EntityManager */
    private $em;

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
        $connection = $this->em->getConnection();
        $tables = $connection->getSchemaManager()->listTables();
        $databasePlatform = $connection->getDatabasePlatform();

        foreach ($tables as $table) {
            $connection->executeQuery(
                $databasePlatform->getTruncateTableSQL($table->getName())
            );
        }
    }

    /**
     * @Given there is a question :question
     */
    public function thereIsAQuestion($question)
    {
        $this->em->getRepository('AppBundle:Question')->addQuestion(['question' => $question]);
    }

    /**
     * @When I request a list of questions
     */
    public function iRequestAListOfQuestions()
    {
        $this->visit('/questions');
    }

    /**
     * @Then I should see a list of questions containing:
     */
    public function iShouldSeeAListOfQuestionsContaining(TableNode $table)
    {
        $page = $this->getPage();
        $listOfQuestions = $page->findAll('css', '.questions li');
        $rows = $table->getHash();

        Assert::assertCount(count($rows), $listOfQuestions, 'The count of questions must be the same');

        for ($i = 0, $count = count($rows); $i < $count; $i++) {
            Assert::assertContains($rows[$i]['question'], $listOfQuestions[$i]->getText());
        }
    }

    /** @return Behat\Mink\Element\DocumentElement */
    private function getPage()
    {
        return $this->getSession()->getPage();
    }
}
