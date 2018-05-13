<?php

namespace DavesWeblab\FilterBundle\Iterator\Handler;

use Pimcore\Model\Listing\AbstractListing;

/**
 * This class can be used for listings that are not implementing the iterator, pagination adapter
 * interfaces but store their data internally as array. For each of them a new Handler needs to be implemented
 * which returns the array via @see AbstractArrayListingHandler::extractArray(). These handlers can the be
 * added via the configuration daves_weblab_filter.iterator.handlers[].
 *
 * Class AbstractArrayListingHandler
 * @package DavesWeblab\FilterBundle\Iterator\Handler
 */
abstract class AbstractArrayListingHandler implements HandlerInterface
{
    /**
     * @param AbstractListing $listing
     * @return array|null
     */
    public abstract function &extractArray(AbstractListing $listing);

    /**
     *   {@inheritdoc}
     */
    public function current(AbstractListing $listing)
    {
        return current($this->extractArray($listing));
    }

    /**
     *   {@inheritdoc}
     */
    public function next(AbstractListing $listing)
    {
        next($this->extractArray($listing));
    }

    /**
     *   {@inheritdoc}
     */
    public function key(AbstractListing $listing)
    {
        return key($this->extractArray($listing));
    }

    /**
     *   {@inheritdoc}
     */
    public function valid(AbstractListing $listing)
    {
        return $this->current($listing) !== false;
    }

    /**
     *   {@inheritdoc}
     */
    public function rewind(AbstractListing $listing)
    {
        return reset($this->extractArray($listing));
    }
}