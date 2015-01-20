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
interface ProviderBagInterface extends BehaviorInterface
{
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
     * @throws \Thelia\VideoManager\Exception\ProviderNotFoundException
     */
    public function get($name, $behavior = self::RETURN_NULL);

    /**
     * @param $name
     * @return bool
     *
     * Check if the provider exists
     */
    public function has($name);

    /**
     * @param $name
     * @param  int                                                      $behavior
     * @return null|bool
     * @throws \Thelia\VideoManager\Exception\ProviderNotFoundException
     *
     * Delete's a provider with its name
     */
    public function delete($name, $behavior = self::THROW_EXCEPTION_ON_ERROR);

    /**
     * @return \Thelia\VideoManager\Provider\ProviderInterface[]
     *
     * Dump all the providers
     */
    public function all();
}
