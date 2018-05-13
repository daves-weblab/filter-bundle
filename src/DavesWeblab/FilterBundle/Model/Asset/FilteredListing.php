<?php

namespace DavesWeblab\FilterBundle\Model\Asset;
use Pimcore\Model\Asset;

/**
 * This class is only used for method hinting. All necessary logic is implemented
 * in @see \DavesWeblab\FilterBundle\Model\FilteredListing
 *
 * @method int load()
 * @method int getTotalCount()
 * @method int getCount()
 * @method int[] loadIdList()
 * @method \Pimcore\Model\Asset\Listing\Dao getDao()
 * @method Asset[] getAssets()
 * @method setAssets(Asset[] $assets)
 */
class FilteredListing extends \DavesWeblab\FilterBundle\Model\FilteredListing
{
}