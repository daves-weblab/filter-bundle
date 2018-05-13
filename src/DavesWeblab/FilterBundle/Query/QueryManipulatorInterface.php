<?php

namespace DavesWeblab\FilterBundle\Query;

use DavesWeblab\FilterBundle\Filter\DataObject\QueryFilterInterface;
use DavesWeblab\FilterBundle\Model\FilteredListing;
use Pimcore\Db\ZendCompatibility\QueryBuilder;

/**
 * Query manipulators are used by the @see FilteredListing via the onQueryCreate hook
 * provided by some listings. They can be freely added in form of a query manipulator directly
 * or via a @see QueryFilterInterface.
 *
 * Interface QueryManipulatorInterface
 * @package DavesWeblab\FilterBundle\Query
 */
interface QueryManipulatorInterface
{
    /**
     * Manipulate the query created by listing to join tables e.g.
     *
     * @param QueryBuilder $query
     *
     * @return mixed
     */
    public function query(QueryBuilder $query);
}