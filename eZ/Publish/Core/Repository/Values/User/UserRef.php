<?php
/**
 * File containing the eZ\Publish\Core\Repository\Values\User\User class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version //autogentag//
 */

namespace eZ\Publish\Core\Repository\Values\User;

use eZ\Publish\API\Repository\Values\User\UserRef as APIUserRef;

/**
 * This class represents a user reference for use in sessions and Repository
 */
class UserRef implements APIUserRef
{
    /**
     * @var mixed
     */
    private $id;

    /**
     * @param mixed $id
     */
    public function __construct( $id )
    {
        $this->id = $id;
    }

    /**
     * The User id of the User this reference represent
     *
     * @return mixed
     */
    public function getUserId()
    {
        return $this->id;
    }
}
