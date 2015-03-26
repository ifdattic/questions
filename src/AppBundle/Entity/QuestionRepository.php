<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class QuestionRepository extends EntityRepository
{
    /** @return Question[] */
    public function getQuestions()
    {
        return $this->createQueryBuilder('q')
            ->select(['q', 't'])
            ->leftJoin('q.tags', 't')
            ->orderBy('q.question', 'ASC')
            ->getQuery()
            ->execute()
        ;
    }

    public function addQuestion(array $data, array $tags = [])
    {
        $em = $this->getEntityManager();
        $question = new Question();
        $question->setQuestion($data['question']);

        foreach ($tags as $tagData) {
            $tag = new Tag();
            $tag->setName($tagData['name']);
            $question->addTag($tag);
        }

        $em->persist($question);
        $em->flush();
    }

    /** @return int */
    public function deleteAll()
    {
        return $this->createQueryBuilder('q')
            ->delete()
            ->getQuery()
            ->execute()
        ;
    }
}
