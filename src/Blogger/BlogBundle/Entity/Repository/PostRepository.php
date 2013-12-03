<?php

namespace Blogger\BlogBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends EntityRepository
{
    public function getLatestPosts($posted = true, $limit = null)
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p', 'c', 't', 'cat')
            ->leftJoin('p.comments', 'c')
            ->leftJoin('p.tags', 't')
            ->leftJoin('p.category', 'cat')
            ->addOrderBy('p.created', 'DESC');

        if (false === is_null($limit))
            $qb->setMaxResults($limit);
        if ($posted === false)
            $qb->where('p.posted = :posted')
                ->setParameter('posted', true);

        return $qb->getQuery()
            ->getResult();
    }

    public function getPostsInCategory($catId) {
        $em = $this->getEntityManager();
        $categories = $em->getRepository('BloggerBlogBundle:Category')->getChildCategories($catId);

        $qb = $this->createQueryBuilder('p')
            ->select('p', 'c', 't', 'cat')
            ->leftJoin('p.comments', 'c')
            ->leftJoin('p.tags', 't')
            ->leftJoin('p.category', 'cat')
            ->where('p.category IN (:ids)')
            ->setParameter('ids', $categories)
            ->addOrderBy('p.created', 'DESC');

        $qb->andWhere('p.posted = :posted')
            ->setParameter('posted', true);

        return $qb->getQuery()
            ->getResult();
    }

    public function getPostsOnTag($tagId) {
        $qb = $this->createQueryBuilder('p')
            ->select('p', 'c', 't', 'cat')
            ->leftJoin('p.comments', 'c')
            ->leftJoin('p.tags', 't')
            ->leftJoin('p.category', 'cat')
            ->where('t.id = :id')
            ->setParameter('id', $tagId)
            ->addOrderBy('p.created', 'DESC');

        $qb->andWhere('p.posted = :posted')
            ->setParameter('posted', true);

        return $qb->getQuery()
            ->getResult();
    }

    public function getPostCountInCategory($category) {
        $em = $this->getEntityManager();
        $categoryRepository = $em->getRepository('BloggerBlogBundle:Category');

        $categoryList = $categoryRepository->findChildren($category);

        $qb = $this->createQueryBuilder('p')
            ->select('count(p)')
            ->innerJoin('p.category', 'c')
            ->where('p.category IN (:ids)')
            ->andWhere('p.posted = 1')
            ->setParameter('ids', $categoryList);

        return $qb->getQuery()->getSingleScalarResult();
    }
}