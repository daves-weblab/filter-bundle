<?php

namespace DavesWeblab\FilterBundle;

use DavesWeblab\FilterBundle\Iterator\Handler\HandlerInterface;
use DavesWeblab\FilterBundle\Iterator\Handler\PaginationListingHandler;
use DavesWeblab\FilterBundle\Model\FilteredListing;
use Pimcore\Model\DataObject\Listing;
use Pimcore\Model\Listing\AbstractListing;

class FilterService
{
    /**
     * @var HandlerInterface[]
     */
    private $handlers;

    public function __construct(array $handlers)
    {
        // setup iterator handlers
        $this->handlers = [
            new PaginationListingHandler()
        ];

        // additional handlers are configured via yml
        // they are injected via the bundles extension
        foreach ($handlers as $handlerClass) {
            $handler = new $handlerClass();

            if (!is_a($handlerClass, HandlerInterface::class)) {
                throw new \InvalidArgumentException("Given class [{$handlerClass}] is not a valid HandlerInterface class.");
            }

            $this->handlers[] = $handler;
        }
    }

    /**
     * @param Listing $listing
     *
     * @return FilteredListing
     */
    public function createFilteredListing(AbstractListing $listing)
    {
        foreach ($this->handlers as $handler) {
            if ($handler->supports($listing)) {
                return new FilteredListing($listing, $handler);
            }
        }

        throw new \InvalidArgumentException("No handler found for given listing [" . get_class($listing) . "]");
    }

    /**
     * @param Listing $listing
     *
     * @return Model\DataObject\FilteredListing
     */
    public function createFilteredDataObjectListing(Listing $listing)
    {
        return $this->createFilteredListing($listing);
    }

    /**
     * @param Listing $listing
     *
     * @return Model\Document\FilteredListing
     */
    public function createFilteredDocumentListing(Listing $listing)
    {
        return $this->createFilteredListing($listing);
    }

    /**
     * @param Listing $listing
     *
     * @return Model\Asset\FilteredListing
     */
    public function createFilteredAssetListing(Listing $listing)
    {
        return $this->createFilteredListing($listing);
    }
}