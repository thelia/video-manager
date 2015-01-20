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

use Thelia\VideoManager\Exception\UnknownUrlTypeException;

/**
 * Class VideoManager
 * @package Thelia\VideoManager
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
class VideoManager extends ProviderBagAware
{
    use BehaviorTrait;

    public function __construct(ProviderBagInterface $providerBag = null)
    {
        $this->providerBag = $providerBag ?: new ProviderBag();
    }

    /**
     * @param $url
     * @param  int                $behavior
     * @return bool|null|VideoUrl
     */
    public function resolve($url, $behavior = BehaviorInterface::RETURN_NULL)
    {
        $this->checkBehavior($behavior);

        foreach ($this->providerBag->all() as $provider) {
            if ($provider->handleUrl($url)) {
                return new VideoUrl($url, $provider);
            }
        }

        switch ($behavior) {
            case BehaviorInterface::THROW_EXCEPTION_ON_ERROR:
                throw new UnknownUrlTypeException(
                    "The url '$url' can't be handled as no provider support it"
                );

            case BehaviorInterface::RETURN_NULL:
                return null;

            case BehaviorInterface::RETURN_BOOLEAN:
                return false;
        }
    }
}
