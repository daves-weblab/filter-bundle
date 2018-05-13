<?php

namespace DavesWeblab\FilterBundle\Iterator\Handler;

use Pimcore\Model\Listing\AbstractListing;
use Zend\Paginator\Adapter\AdapterInterface;

/**
 * Extension of the @see HandlerInterface. Also supports pagination.
 *
 * Interface PaginationHandlerInterface
 * @package DavesWeblab\FilterBundle\Iterator\Handler
 */
interface PaginationHandlerInterface extends HandlerInterface
{
    /**
     * @param AbstractListing $listing
     * @param int $offset
     * @param int $itemCountPerPage
     *
     * @return array
     */
    public function getItems(AbstractListing $listing, $offset, $itemCountPerPage);

    /**
     * @param AbstractListing $listing
     *
     * @return int
     */
    public function count(AbstractListing $listing);

    /**
     * @param AbstractListing $listing
     *
     * @return AdapterInterface
     */
    public function getPaginatorAdapter(AbstractListing $listing);
}