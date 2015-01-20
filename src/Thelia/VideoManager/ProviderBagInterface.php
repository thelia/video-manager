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

use Thelia\VideoManager\Provider\ProviderInterface;

/**
 * Interface ProviderBagInterface
 * @package Thelia\VideoManager
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
interface ProviderBagInterface
{
    const RETURN_BOOLEAN = 0;
    const THROW_EXCEPTION_ON_ERROR = 1;
    const RETURN_NULL = 2;

    /**
     * @param  ProviderInterface $provider
     * @param  null              $alias
     * @return $this
     *
     * Adds a provider to the bag.
     * The provider alias is defined in the second parameter.
     * If there in no alias (null) the alias is taken from the provider getName method.
     */
    public function add(ProviderInterface $provider, $alias = null);

    /**
     * @param $name
     * @param  int                                                        $behavior
     * @return null|false|\Thelia\VideoManager\Provider\ProviderInterface
     *
     *
     */
    public function get($name, $behavior = self::RETURN_NULL);
}
