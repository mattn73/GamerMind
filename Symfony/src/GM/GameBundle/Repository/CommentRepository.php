<?php

namespace GM\GameBundle\Repository;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 * 
 * 
 */

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;


class CommentRepository extends \Doctrine\ORM\EntityRepository
{

    public function myFindAll()
    {
   
        
        $query = $this->createQueryBuilder('a')
        ->join('a.game', 'g')
        ->join('a.user', 'u')
        ->addSelect('u')
        ->addSelect('g')
        ->getQuery();

        $results = $query->getResult();

       
        return $results;
    }
}
