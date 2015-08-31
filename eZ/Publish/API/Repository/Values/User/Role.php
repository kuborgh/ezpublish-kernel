<?php

/**
 * File containing the eZ\Publish\API\Repository\Values\User\Role class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 *
 * @version //autogentag//
 */
namespace eZ\Publish\API\Repository\Values\User;

use eZ\Publish\API\Repository\Values\ValueObject;

/**
 * This class represents a role.
 *
 * @property-read mixed $id the internal id of the role
 * @property-read string $identifier the identifier of the role
 *
 * @property-read array $policies an array of the policies {@link \eZ\Publish\API\Repository\Values\User\Policy} of the role.
 */
abstract class Role extends ValueObject
{
    /**
     * @var int Status constant for defined (aka "published") role
     */
    const STATUS_DEFINED = 0;

    /**
     * @var int Status constant for draft (aka "temporary") role
     */
    const STATUS_DRAFT = 1;

    /**
     * @var int Status constant for modified (aka "deferred for publishing") role
     *
     * Reserved for future use, e.g. to delay cache invalidation after a role change.
     */
    const STATUS_MODIFIED = 2;

    /**
     * ID of the user role.
     *
     * @var mixed
     */
    protected $id;

    /**
     * Readable string identifier of a role
     * in 4.x. this is mapped to the role name.
     *
     * @var string
     */
    protected $identifier;

    /**
     * The status of the role.
     *
     * @var int One of Role::STATUS_DEFINED|Role::STATUS_DRAFT|Role::STATUS_MODIFIED
     */
    protected $status;

    /**
     * Creation date of the role.
     *
     * @var \DateTime
     */
    protected $creationDate;

    /**
     * Modification date of the role.
     *
     * @var \DateTime
     */
    protected $modificationDate;

    /**
     * Creator user id of the role.
     *
     * @var mixed
     */
    protected $creatorId;

    /**
     * Modifier user id of the role.
     *
     * @var mixed
     */
    protected $modifierId;

    /**
     * Returns the list of policies of this role.
     *
     * @return \eZ\Publish\API\Repository\Values\User\Policy[]
     */
    abstract public function getPolicies();
}
