<?php

namespace DavesWeblab\FilterBundle\Model;

use DavesWeblab\FilterBundle\Filter\DataObject\FilterInterface;
use DavesWeblab\FilterBundle\Filter\DataObject\QueryFilterInterface;
use DavesWeblab\FilterBundle\Filter\ResettableFilterInterface;
use DavesWeblab\FilterBundle\Iterator\Handler\HandlerInterface;
use DavesWeblab\FilterBundle\Iterator\Handler\PaginationHandlerInterface;
use DavesWeblab\FilterBundle\Query\QueryManipulatorInterface;
use Pimcore\Db\ZendCompatibility\QueryBuilder;
use Pimcore\Model\Listing\AbstractListing;
use Zend\Paginator\Adapter\AdapterInterface;
use Zend\Paginator\AdapterAggregateInterface;

/**
 * This is the base class for all filtered listings. It can be used to add / reset filters
 * and query manipulators. All methods not implemented directly by this class are proxied to
 * the underlying listing. Each Filtered listing need a handler for iterating the list, since there
 * are some listings which do not implement the @see \Iterator interface.
 *
 * @method bool isValidOrderKey($key)
 * @method int getLimit()
 * @method int getOffset()
 * @method array|string getOrder()
 * @method setLimit(int $limit)
 * @method setOffset(int $offset)
 * @method setOrder(array | string $order)
 * @method array|string getOrderKey()
 * @method setOrderKey(string | array $orderKey, bool $quote = true)
 * @method addConditionParam($key, $value = null, $concatenator = "AND")
 * @method array getConditionParams()
 * @method resetConditionParams()
 * @method string getCondition()
 * @method setCondition($condition, $conditionVariables = null)
 * @method string getGroupBy()
 * @method array getValidOrders()
 * @method setGroupBy($groupBy, $qoute = true)
 * @method setValidOrders($validOrders)
 * @method string quote($value, $type = null)
 * @method setConditionVariables(array $conditionVariables)
 * @method array getConditionVariables()
 * @method setConditionVariablesFromSetCondition(array $conditionVariables)
 * @method array getConditionVariablesFromSetCondition()
 */
class FilteredListing implements \Iterator, AdapterInterface, AdapterAggregateInterface
{
    /**
     * @var QueryManipulatorInterface[]
     */
    private $queryManipulators;

    /**
     * @var FilterInterface[]
     */
    private $filters;

    /**
     * @var AbstractListing
     */
    private $listing;

    /**
     * @var HandlerInterface
     */
    private $handler;

    public function __construct(AbstractListing $listing, HandlerInterface $handler)
    {
        $this->queryManipulators = [];
        $this->filters = [];
        $this->listing = $listing;
        $this->handler = $handler;

        $dao = $this->listing->getDao();

        // hook into the on create query callback if possible
        if (method_exists($dao, "onCreateQuery")) {
            $dao->onCreateQuery([$this, "onCreateQuery"]);
        }
    }

    /**
     * @param QueryBuilder $query
     */
    protected function onCreateQuery(QueryBuilder $query)
    {
        foreach ($this->queryManipulators as $queryManipulator) {
            $queryManipulator->query($query);
        }
    }

    /**
     * @param QueryManipulatorInterface $queryManipulator
     */
    public function addQueryManipulator(QueryManipulatorInterface $queryManipulator)
    {
        $this->queryManipulators[] = $queryManipulator;
    }

    /**
     * @param FilterInterface $filter
     */
    public function addFilter(FilterInterface $filter)
    {
        $filter->apply($this->listing);

        $this->filters[] = $filter;

        if ($filter instanceof QueryFilterInterface) {
            $this->addQueryManipulator($filter);
        }
    }

    /**
     * @param string|ResettableFilterInterface $filter
     */
    public function resetFilter($filter)
    {
        if (is_string($filter)) {
            foreach ($this->filters as $f) {
                if (is_a($f, $filter) && $f instanceof ResettableFilterInterface) {
                    $f->reset($this->listing);
                }
            }
        } else if ($filter instanceof ResettableFilterInterface) {
            $filter->reset($this->listing);
        }
    }

    /**
     * @return AbstractListing
     */
    public function getListing(): AbstractListing
    {
        return $this->listing;
    }

    /**
     * @return HandlerInterface
     */
    public function getHandler(): HandlerInterface
    {
        return $this->handler;
    }

    /**
     * Proxy any method to the listing if possible.
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this->listing, $name)) {
            return call_user_func_array([$this->listing, $name], $arguments);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->handler->current($this->listing);
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->handler->next($this->listing);
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->handler->key($this->listing);
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->handler->valid($this->listing);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->handler->rewind($this->listing);
    }

    /**
     * {@inheritdoc}
     */
    public function getPaginatorAdapter()
    {
        if (!$this->handler instanceof PaginationHandlerInterface) {
            throw new \InvalidArgumentException("Handler [" . get_class($this->handler) . "] for listing [" . get_class($this->listing) . "] is not a valid pagination handler.");
        }

        return $this->handler->getPaginatorAdapter($this->listing);
    }

    /**
     * {@inheritdoc}
     */
    public function getItems($offset, $itemCountPerPage)
    {
        if (!$this->handler instanceof PaginationHandlerInterface) {
            throw new \InvalidArgumentException("Handler [" . get_class($this->handler) . "] for listing [" . get_class($this->listing) . "] is not a valid pagination handler.");
        }

        return $this->handler->getItems($this->listing, $offset, $itemCountPerPage);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        if (!$this->handler instanceof PaginationHandlerInterface) {
            throw new \InvalidArgumentException("Handler [" . get_class($this->handler) . "] for listing [" . get_class($this->listing) . "] is not a valid pagination handler.");
        }

        return $this->handler->count($this->listing);
    }
}