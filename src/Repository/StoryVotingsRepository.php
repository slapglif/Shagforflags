<?php

namespace App\Repository;

use App\Entity\StoryVotings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StoryVotings|null find($id, $lockMode = null, $lockVersion = null)
 * @method StoryVotings|null findOneBy(array $criteria, array $orderBy = null)
 * @method StoryVotings[]    findAll()
 * @method StoryVotings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoryVotingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StoryVotings::class);
    }

    public function getVote($user_id, $story_id) {
        $vote = $this->createQueryBuilder("V")
            ->select("V")
            ->where("V.userId = :user_id")
            ->andWhere("V.storyId = :story_id")
            ->setParameter('user_id', $user_id)
            ->setParameter('story_id', $story_id)
            ->getQuery()
            ->getOneOrNullResult();

        return $vote;
    }

    public function getStoryVotesUp($story_id) {
        $vote = $this->createQueryBuilder("V")
            ->select("COUNT(V)")
            ->where("V.storyId = :story_id")
            ->andWhere("V.vote = '1'")
            ->setParameter('story_id', $story_id)
            ->getQuery()
            ->getSingleScalarResult();

        return $vote;
    }

    public function getStoryVotesDown($story_id) {
        $vote = $this->createQueryBuilder("V")
            ->select("COUNT(V)")
            ->where("V.storyId = :story_id")
            ->andWhere("V.vote = '0'")
            ->setParameter('story_id', $story_id)
            ->getQuery()
            ->getSingleScalarResult();

        return $vote;
    }

    // /**
    //  * @return StoryVotings[] Returns an array of StoryVotings objects
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
    public function findOneBySomeField($value): ?StoryVotings
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
