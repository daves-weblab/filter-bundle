<?php

namespace DavesWeblab\FilterBundle\Iterator\Handler;

use Pimcore\Model\Listing\AbstractListing;
use Zend\Paginator\Adapter\AdapterInterface;
use Zend\Paginator\AdapterAggregateInterface;

abstract class AbstractPaginationListingHandler extends AbstractIterableListingHandler implements PaginationHandlerInterface
{
    public function supports(AbstractListing $listing): bool
    {
        return parent::supports($listing) && $listing instanceof AdapterInterface && $listing instanceof AdapterAggregateInterface;
    }

    /**
     * @param AdapterInterface $listing
     * @param int $offset
     * @param int $itemCountPerPage
     *
     * @return array
     */
    public function getItems(AbstractListing $listing, $offset, $itemCountPerPage)
    {
        return $listing->getItems($offset, $itemCountPerPage);
    }

    /**
     * @param \Countable $listing
     * @return int
     */
    public function count(AbstractListing $listing)
    {
        return $listing->count();
    }

    /**
     * @param AdapterAggregateInterface $listing
     *
     * @return AbstractListing|AdapterInterface
     */
    public function getPaginatorAdapter(AbstractListing $listing)
    {
        return $listing->getPaginatorAdapter();
    }
}