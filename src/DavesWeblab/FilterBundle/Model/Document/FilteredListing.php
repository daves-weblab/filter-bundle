<?php

namespace DavesWeblab\FilterBundle\Model\Document;

use Pimcore\Model\Document;

/**
 * This class is only used for method hinting. All necessary logic is implemented
 * in @see \DavesWeblab\FilterBundle\Model\FilteredListing
 *
 * @method int load()
 * @method int getTotalCount()
 * @method int getCount()
 * @method int loadIdList()
 * @method \Pimcore\Model\Document\Listing\Dao getDao()
 * @method Document[] getDocuments()
 * @method setDocuments(Document[] $documents)
 * @method bool getUnpublished()
 * @method setUnpublished(bool $unpublished)
 */
class FilteredListing extends \DavesWeblab\FilterBundle\Model\FilteredListing
{
}