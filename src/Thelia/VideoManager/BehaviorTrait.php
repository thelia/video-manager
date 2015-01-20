<?php
/*************************************************************************************/
/* This file is part of the Thelia package.                                          */
/*                                                                                   */
/* Copyright (c) OpenStudio                                                          */
/* email : dev@thelia.net                                                            */
/* web : http://www.thelia.net                                                       */
/*                                                                                   */
/* For the full copyright and license information, please view the LICENSE.txt       */
/* file that was distributed with this source code.                                  */
/*************************************************************************************/

namespace Thelia\VideoManager;

use Thelia\VideoManager\Exception\UnknownBehaviorException;

/**
 * Trait BehaviorTrait
 * @package Thelia\VideoManager
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
trait BehaviorTrait
{
    protected static  $behaviors = array(
        BehaviorInterface::THROW_EXCEPTION_ON_ERROR,
        BehaviorInterface::RETURN_BOOLEAN,
        BehaviorInterface::RETURN_NULL,
    );


    protected function checkBehavior($behavior)
    {
        if (!in_array($behavior, static::$behaviors)) {
            throw new UnknownBehaviorException(
                "The behavior '$behavior' doesn't exist"
            );
        }
    }
}
