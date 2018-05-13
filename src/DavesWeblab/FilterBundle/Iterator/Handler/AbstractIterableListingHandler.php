<?php

namespace DavesWeblab\FilterBundle\Iterator\Handler;

use Pimcore\Model\Listing\AbstractListing;

abstract class AbstractIterableListingHandler implements HandlerInterface
{
    public function supports(AbstractListing $listing): bool
    {
        return $listing instanceof \Iterator;
    }

    /**
     * @param \Iterator $listing
     *
     * @return mixed
     */
    public function current(AbstractListing $listing)
    {
        return $listing->current();
    }

    /**
     * @param \Iterator $listing
     */
    public function next(AbstractListing $listing)
    {
        $listing->next();
    }

    /**
     * @param \Iterator $listing
     *
     * @return mixed
     */
    public function key(AbstractListing $listing)
    {
        return $listing->key();
    }

    /**
     * @param \Iterator $listing
     *
     * @return bool
     */
    public function valid(AbstractListing $listing)
    {
        return $listing->valid();
    }

    /**
     * @param \Iterator $listing
     */
    public function rewind(AbstractListing $listing)
    {
        $listing->rewind();
    }
}