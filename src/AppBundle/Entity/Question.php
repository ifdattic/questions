<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Tag;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\QuestionRepository")
 */
class Question
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="question", type="text")
     */
    private $question;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="questions", cascade={"persist"})
     * @ORM\JoinTable(name="questions_tags")
     * @ORM\OrderBy({"name"="ASC"})
     */
    private $tags;

    /** @var boolean a flag to check if tags collection was sorted */
    private $isTagsSorted = false;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set question
     *
     * @param string $question
     * @return Question
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Add tags
     *
     * @param \AppBundle\Entity\Tag $tags
     * @return Question
     */
    public function addTag(Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \AppBundle\Entity\Tag $tags
     */
    public function removeTag(Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        $this->sortTagsAlphabetically();

        return $this->tags;
    }

    /** @return void */
    private function sortTagsAlphabetically()
    {
        if ($this->isTagsSorted) {
            return;
        }

        $tags = $this->tags->toArray();

        usort($tags, function ($a, $b) {
            return $a->getName() > $b->getName();
        });

        $this->tags = new ArrayCollection($tags);
    }
}
