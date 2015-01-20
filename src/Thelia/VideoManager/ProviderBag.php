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

use Thelia\VideoManager\Exception\ProviderNotFoundException;
use Thelia\VideoManager\Provider\ProviderInterface;

/**
 * Class ProviderBag
 * @package Thelia\VideoManager
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
class ProviderBag implements ProviderBagInterface
{
    use BehaviorTrait;

    protected $providers;

    public function add(ProviderInterface $provider, $alias = null)
    {
        if (null === $alias) {
            $alias = $provider->getName();
        }

        $this->providers[$alias] = $provider;

        return $this;
    }

    public function get($name, $behavior = self::RETURN_NULL)
    {
        $this->checkBehavior($behavior);

        if ($this->has($name)) {
            return $this->providers[$name];
        }

        switch ($behavior) {
            case static::RETURN_BOOLEAN:
                return false;

            case static::RETURN_NULL:
                return;

            case static::THROW_EXCEPTION_ON_ERROR:
                throw new ProviderNotFoundException(
                    "The provider '$name' doesn't exist"
                );
        }
    }

    public function has($name)
    {
        return isset($this->providers[$name]);
    }

    public function delete($name, $behavior = self::THROW_EXCEPTION_ON_ERROR)
    {
        $this->checkBehavior($behavior);

        if ($exists = $this->has($name)) {
            unset($this->providers[$name]);
        }

        switch ($behavior) {
            case static::RETURN_BOOLEAN:
                return $exists;

            case static::RETURN_NULL:
                return;

            case static::THROW_EXCEPTION_ON_ERROR:
                if ($exists) {
                    return $this;
                }

                throw new ProviderNotFoundException(
                    "The provider '$name' doesn't exist"
                );
        }
    }

    public function all()
    {
        return $this->providers;
    }
}
