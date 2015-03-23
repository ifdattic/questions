<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Tag;
use Doctrine\ORM\EntityRepository;

class TagRepository extends EntityRepository
{
    /** @return int */
    public function deleteAll()
    {
        return $this->createQueryBuilder('t')
            ->delete()
            ->getQuery()
            ->execute()
        ;
    }

    /** @return Tag[] */
    public function getTags()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.name', 'ASC')
            ->getQuery()
            ->execute()
        ;
    }

    public function addTag(array $data)
    {
        $em = $this->getEntityManager();
        $tag = new Tag();
        $tag->setName($data['name']);

        $em->persist($tag);
        $em->flush();
    }
}
