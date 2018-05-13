<?php

namespace DavesWeblab\FilterBundle\Filter;

use DavesWeblab\FilterBundle\Filter\DataObject\FilterInterface;
use Pimcore\Model\Listing\AbstractListing;

interface ResettableFilterInterface extends FilterInterface
{
    /**
     * Reset the filter from the given listing it has been
     * applied to before.
     *
     * @param AbstractListing $listing
     *
     * @return mixed
     */
    public function reset(AbstractListing $listing);
}