<?php

/*
 * This file is part of the FOSElasticaBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\ElasticaBundle\Paginator;

use Elastica\Query;
use Elastica\SearchableInterface;
use FOS\ElasticaBundle\Transformer\ElasticaToModelTransformerInterface;

/**
 * Allows pagination of \Elastica\Query.
 */
class TransformedScrollPaginatorAdapter extends RawScrollPaginatorAdapter
{
    private $transformer;

    /**
     * @param SearchableInterface                 $searchable  the object to search in
     * @param Query                               $query       the query to search
     * @param array                               $options
     * @param ElasticaToModelTransformerInterface $transformer the transformer for fetching the results
     */
    public function __construct(SearchableInterface $searchable, Query $query, array $options, ElasticaToModelTransformerInterface $transformer)
    {
        parent::__construct($searchable, $query, $options);

        $this->transformer = $transformer;
    }

    /**
     * {@inheritdoc}
     */
    public function getResults($offset, $length)
    {
        return new TransformedPartialResults($this->getElasticaResults($offset, $length), $this->transformer);
    }
}
