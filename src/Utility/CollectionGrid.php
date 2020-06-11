<?php

namespace Application\Utility;

use JasperFW\DataAccess\DAO;
use JasperFW\DataModel\Grid;
use Psr\Log\LoggerInterface;

class CollectionGrid extends Grid
{
    public function __construct(DAO $dao, ?LoggerInterface $logger = null)
    {
        parent::__construct($dao, $logger);
    }

    public function generateQuery(): string
    {
        // TODO: Implement generateQuery() method.
    }
}