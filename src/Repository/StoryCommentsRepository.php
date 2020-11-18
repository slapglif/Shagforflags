<?php

namespace App\Repository;

use App\Entity\StoryComments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StoryComments|null find($id, $lockMode = null, $lockVersion = null)
 * @method StoryComments|null findOneBy(array $criteria, array $orderBy = null)
 * @method StoryComments[]    findAll()
 * @method StoryComments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoryCommentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StoryComments::class);
    }

    public function getCommentCount($story_id) {
        $comment = $this->createQueryBuilder("C")
            ->select("COUNT(C)")
            ->where("C.storyId = :story_id")
            ->setParameter('story_id', $story_id)
            ->getQuery()
            ->getSingleScalarResult();

        return $comment;
    }

    public function getStoryComments($story_id) {
        $comments = $this->createQueryBuilder("C")
            ->select("C")
            ->where("C.storyId = :story_id")
            ->setParameter('story_id', $story_id)
            ->getQuery()
            ->getResult();

        return $comments;
    }

    // /**
    //  * @return StoryComments[] Returns an array of StoryComments objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StoryComments
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
