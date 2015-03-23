<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class QuestionRepository extends EntityRepository
{
    /** @return Question[] */
    public function getQuestions()
    {
        return $this->createQueryBuilder('q')
            ->orderBy('q.question', 'ASC')
            ->getQuery()
            ->execute()
        ;
    }

    public function addQuestion(array $data)
    {
        $em = $this->getEntityManager();
        $question = new Question();
        $question->setQuestion($data['question']);

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
