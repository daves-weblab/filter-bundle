<?php

namespace DavesWeblab\FilterBundle\Filter\DataObject;

use Pimcore\Model\Listing\AbstractListing;

interface FilterInterface
{
    /**
     * Apply this filter on the given listing.
     *
     * @param AbstractListing $listing
     *
     * @return mixed
     */
    public function apply(AbstractListing $listing);
}