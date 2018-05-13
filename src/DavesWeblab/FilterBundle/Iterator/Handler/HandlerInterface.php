<?php

namespace DavesWeblab\FilterBundle\Iterator\Handler;

use Pimcore\Model\Listing\AbstractListing;

/**
 * Base interface for each iterator handler for listings. Which handler is used for which
 * listing is defined by the @see HandlerInterface::supports() method.
 *
 * Interface HandlerInterface
 * @package DavesWeblab\FilterBundle\Iterator\Handler
 */
interface HandlerInterface
{
    /**
     * Check whether the extractor supports the given listing or not.
     *
     * @param AbstractListing $listing
     *
     * @return bool
     */
    public function supports(AbstractListing $listing): bool;

    /**
     * @param AbstractListing $listing
     *
     * @return mixed
     */
    public function current(AbstractListing $listing);

    /**
     * @param AbstractListing $listing
     *
     * @return void
     */
    public function next(AbstractListing $listing);

    /**
     * @param AbstractListing $listing
     *
     * @return mixed
     */
    public function key(AbstractListing $listing);

    /**
     * @param AbstractListing $listing
     *
     * @return bool
     */
    public function valid(AbstractListing $listing);

    /**
     * @param AbstractListing $listing
     *
     * @return void
     */
    public function rewind(AbstractListing $listing);
}