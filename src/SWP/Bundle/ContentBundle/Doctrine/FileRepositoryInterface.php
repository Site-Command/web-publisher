<?php

declare(strict_types=1);

/*
 * This file is part of the Superdesk Web Publisher Content Bundle.
 *
 * Copyright 2018 Sourcefabric z.ú. and contributors.
 *
 * For the full copyright and license information, please see the
 * AUTHORS and LICENSE files distributed with this source code.
 *
 * @copyright 2018 Sourcefabric z.ú
 * @license http://www.superdesk.org/license
 */

namespace SWP\Bundle\ContentBundle\Doctrine;

use Doctrine\ORM\QueryBuilder;
use SWP\Bundle\ContentBundle\Model\FileInterface;
use SWP\Component\Common\Criteria\Criteria;
use SWP\Component\Storage\Repository\RepositoryInterface;

interface FileRepositoryInterface extends RepositoryInterface
{
    public function getByCriteria(Criteria $criteria, array $sorting): QueryBuilder;

    public function findFileByAssetId(string $assetId): ?FileInterface;
}
