# Filter Bundle

This bundle extends the basic Pimcore listings (data objects, assets, documents, ...)
by filters and query manipulators.

## Installation

The bundle can be installed via composer (not on packagist yet).

``> composer require daves-weblab/filter-bundle``

And needs to be enabled in the Kernel.

``$collection->addBundle(new \DavesWeblab\FilterBundle\DavesWeblabFilterBundle());``

## Usage

The bundle provides a simple service to wrap given listings with their filterable counterpart.

```php
use DavesWeblab\FilterBundle\FilterService;

$filteredListing = $filterService
    ->createFilteredListing(Pimcore\Model\DataObject\SomeObject::getList());
    
// methods are proxied to the underlying listing and are hinted via comments
$filteredListing->addConditionParam("xxx = ?", $xxx);
```

This returns an instance of ``DavesWeblab\FilterBundle\Model\FilteredListing``. A ``FilteredListing``
provides methods for adding / resetting filters as well as adding query manipulators for joining. A ``FilteredListing``
also proxies all method calls to the underlying listing if possible.

There are various differentiations like ``DavesWeblab\FilterBundle\Model\DataObject\FilteredListing`` but in the end
they are only a ``FilteredListing`` with comments for method hinting.

### Filters

As mentioned a ``FilteredListing`` can take in filters extending the ``FilterInterface``. There are also extension of this
interface like the ``ResettableFilterInterface`` for filters that can be resetted and the ``QueryFilterInterface`` for filters
who are a query manipulator at the same time.

```php
class SomeFilter implmements FilterInterface 
{
    public function apply(AbstractListing $listing) { ... }
}

$filteredListing->addFilter(new SomeFilter());
```

### Query Manipulators

Some Pimcore listings provide a way to manipulate the query using the onCreateQuery hook. Sadly a listing can only
have one query manipulating callback at the same time. When using filters, some of them need the ability to add joins
to the query and manipulate it. The ``FilteredListing`` provides a method to add multiple query manipulators. Those
are classes implementing the ``QueryManipulatorInterface``. When adding a filter to the ``FilteredListing`` that implements 
the ``QueryManipulatorInterface`` as well, it is registered as a query manipulator automatically. This can be shortened by only
implementing the ``QueryFilterInterface``.

```php
class SomeQueryFilter implements QueryFilterInterface
{
    public function apply(AbstractListing $listing) { ... }
    
    // add joins etc.
    public function query(QueryBuilder $query) { ... }
}

class SomeQueryManipulator implements QueryManipulatorInterface 
{
    public function query(QueryBuilder $query) { ... }
}

// automatically registeres a query manipulator
$filteredListing->addFilter(new SomeQueryFilter()); 

$filteredListing->addQueryManipulator(new SomeQueryManipulator());
```

## Extending the Bundle

All functionalities for iteration provided by the ``FilteredListing`` comes from a so called iterator handler. They decide
how to iterate the underlying listing. For example a listing for sites does not implement the ``\Iterator`` interface nor
the necessary interfaces for the ``Paginator``. A iterator handler takes care of proxying and wrapping this functionality.

There are already a variety of iterator handlers available like the ``DavesWeblab\FilterBundle\Iterator\Handler\PaginationListingHandler``
which takes care for listings that already implement all necessary interfaces. The ``DavesWeblab\FilterBundle\Iterator\Handler\AbstractArrayListingHandler``
can be used for listings that only store an internal array, but do not implement those interfaces. A handler extending the ``AbstractArrayListingHandler`` only
needs to implement the method ``extractArray()`` where the internal array should be returned. Which handler is used for which listing is decided by the handlers
``support()`` method.

### Add a new iterator handler

New iterator handlers can be added via the configuration.

```php
namespace AppBundle\Filter\Iterator\Handler;

class SiteListingHandler extends AbstractArrayListingHandler
{
    public function supports(AbstractListing $listing) 
    {
        return $listing instanceof Pimcore\Model\Site\Listing;
    }

    /**
     * @var Pimcore\Model\Site\Listing $listing
     */
    public function &extractArray(AbstractListing $listing) 
    {
        return $listing->sites;
    }
}

// config.yml
daves_weblab_filter:
    iterator:
        handlers:
            - AppBundle\Filter\Iterator\Handler\SiteListingHandler
```