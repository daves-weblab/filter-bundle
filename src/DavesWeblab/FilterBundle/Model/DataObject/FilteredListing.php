<?php

namespace DavesWeblab\FilterBundle\Model\DataObject;

use Pimcore\Model\DataObject;

/**
 * This class is only used for method hinting. All necessary logic is implemented
 * in @see \DavesWeblab\FilterBundle\Model\FilteredListing
 *
 * @method int load()
 * @method int getTotalCount()
 * @method int getCount()
 * @method int loadIdList()
 * @method \Pimcore\Model\DataObject\Listing\Dao getDao()
 * @method DataObject[] getObjects()
 * @method setObjects(array $objects)
 * @method bool getUnpublished()
 * @method bool setUnpublished(bool $unpublished)
 * @method setObjectTypes($objectTypes)
 * @method array getObjectTypes()
 * @method bool addDistinct()
 */
class FilteredListing extends \DavesWeblab\FilterBundle\Model\FilteredListing
{
}