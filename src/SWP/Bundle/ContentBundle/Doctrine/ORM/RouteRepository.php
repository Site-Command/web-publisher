<?php

/*
 * This file is part of the Superdesk Web Publisher Content Bundle.
 *
 * Copyright 2016 Sourcefabric z.ú. and contributors.
 *
 * For the full copyright and license information, please see the
 * AUTHORS and LICENSE files distributed with this source code.
 *
 * @copyright 2016 Sourcefabric z.ú
 * @license http://www.superdesk.org/license
 */

namespace SWP\Bundle\ContentBundle\Doctrine\ORM;

use Doctrine\ORM\QueryBuilder;
use SWP\Bundle\ContentBundle\Model\RouteRepositoryInterface;
use SWP\Bundle\StorageBundle\Doctrine\ORM\NestedTreeEntityRepository;
use SWP\Component\Common\Criteria\Criteria;

class RouteRepository extends NestedTreeEntityRepository implements RouteRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getChildrenByStaticPrefix(array $candidates, array $orderBy): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('r');
        $queryBuilder->andWhere($queryBuilder->expr()->in('r.parent', $candidates));
        $this->applySorting($queryBuilder, $orderBy, 'r');

        return $queryBuilder;
    }

    public function countByCriteria(Criteria $criteria): int
    {
        $queryBuilder = $this->createQueryBuilder('r')
            ->select('COUNT(r.id)');

        $this->applyCriteria($queryBuilder, $criteria, 'r');

        return (int) $queryBuilder->getQuery()->getSingleScalarResult();
    }
}
