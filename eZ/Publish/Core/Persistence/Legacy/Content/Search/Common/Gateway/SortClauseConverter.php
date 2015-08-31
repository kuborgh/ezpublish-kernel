<?php
/**
 * File containing the DoctrineDatabase sort clause converter class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version //autogentag//
 */

namespace eZ\Publish\Core\Persistence\Legacy\Content\Search\Common\Gateway;

use eZ\Publish\Core\Persistence\Legacy\Content\Search\Common\Gateway\SortClauseHandler;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\Core\Persistence\Database\SelectQuery;
use RuntimeException;

/**
 * Converter manager for sort clauses
 */
class SortClauseConverter
{
    /**
     * Sort clause handlers
     *
     * @var \eZ\Publish\Core\Persistence\Legacy\Content\Search\Common\Gateway\SortClauseHandler[]
     */
    protected $handlers;

    /**
     * Sorting information for temporary sort columns
     *
     * @var array
     */
    protected $sortColumns = array();

    /**
     * Construct from an optional array of sort clause handlers
     *
     * @param \eZ\Publish\Core\Persistence\Legacy\Content\Search\Common\Gateway\SortClauseHandler[] $handlers
     */
    public function __construct( array $handlers = array() )
    {
        $this->handlers = $handlers;
    }

    /**
     * Adds handler
     *
     * @param \eZ\Publish\Core\Persistence\Legacy\Content\Search\Common\Gateway\SortClauseHandler $handler
     */
    public function addHandler( SortClauseHandler $handler )
    {
        $this->handlers[] = $handler;
    }

    /**
     * Apply select parts of sort clauses to query
     *
     * @throws \RuntimeException If no handler is available for sort clause
     *
     * @param \eZ\Publish\Core\Persistence\Database\SelectQuery $query
     * @param \eZ\Publish\API\Repository\Values\Content\Query\SortClause[] $sortClauses
     */
    public function applySelect( SelectQuery $query, array $sortClauses )
    {
        foreach ( $sortClauses as $nr => $sortClause )
        {
            foreach ( $this->handlers as $handler )
            {
                if ( $handler->accept( $sortClause ) )
                {
                    foreach ( (array)$handler->applySelect( $query, $sortClause, $nr ) as $column )
                    {
                        $this->sortColumns[$column] = $sortClause->direction;
                    }
                    continue 2;
                }
            }

            throw new RuntimeException( 'No handler available for sort clause: ' . get_class( $sortClause ) );
        }
    }

    /**
     * Apply join parts of sort clauses to query
     *
     * @throws \RuntimeException If no handler is available for sort clause
     *
     * @param \eZ\Publish\Core\Persistence\Database\SelectQuery $query
     * @param \eZ\Publish\API\Repository\Values\Content\Query\SortClause[] $sortClauses
     */
    public function applyJoin( SelectQuery $query, array $sortClauses )
    {
        foreach ( $sortClauses as $nr => $sortClause )
        {
            foreach ( $this->handlers as $handler )
            {
                if ( $handler->accept( $sortClause ) )
                {
                    $handler->applyJoin( $query, $sortClause, $nr );
                    continue 2;
                }
            }

            throw new RuntimeException( 'No handler available for sort clause: ' . get_class( $sortClause ) );
        }
    }

    /**
     * Apply order by parts of sort clauses to query
     *
     * @param \eZ\Publish\Core\Persistence\Database\SelectQuery $query
     */
    public function applyOrderBy( SelectQuery $query )
    {
        foreach ( $this->sortColumns as $column => $direction )
        {
            $query->orderBy(
                $column,
                $direction === Query::SORT_ASC ? SelectQuery::ASC : SelectQuery::DESC
            );
        }
    }
    
    /**
     * Reset all information on this singleton class
     */
    public function reset()
    {
        $this->sortColumns = array();
    }
}

