<?php

/**
 * File containing the PolicyUpdateStruct ValueObjectVisitor class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 *
 * @version //autogentag//
 */

namespace eZ\Publish\Core\REST\Client\Output\ValueObjectVisitor;

use eZ\Publish\Core\REST\Common\Output\ValueObjectVisitor;
use eZ\Publish\Core\REST\Common\Output\Generator;
use eZ\Publish\Core\REST\Common\Output\Visitor;

/**
 * PolicyUpdateStruct value object visitor.
 */
class PolicyUpdateStruct extends ValueObjectVisitor
{
    /**
     * Visit struct returned by controllers.
     *
     * @param \eZ\Publish\Core\REST\Common\Output\Visitor $visitor
     * @param \eZ\Publish\Core\REST\Common\Output\Generator $generator
     * @param mixed $data
     */
    public function visit(Visitor $visitor, Generator $generator, $data)
    {
        $generator->startObjectElement('PolicyUpdate');
        $visitor->setHeader('Content-Type', $generator->getMediaType('PolicyUpdate'));

        $limitations = $data->getLimitations();
        if (!empty($limitations)) {
            $generator->startObjectElement('limitations');
            $generator->startList('limitations');

            foreach ($limitations as $limitation) {
                $visitor->visitValueObject($limitation);
            }

            $generator->endList('limitations');
            $generator->endObjectElement('limitations');
        }

        $generator->endObjectElement('PolicyUpdate');
    }
}
