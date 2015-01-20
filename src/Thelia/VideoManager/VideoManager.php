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
class VideoManager
{
    use BehaviorTrait;

    protected $providerBag;

    public function __construct(ProviderBagBuilderInterface $providerBagBuilder = null)
    {
        $providerBagBuilder = $providerBagBuilder ?: new ProviderBagBuilder();

        $this->providerBag = $providerBagBuilder->createProviderBag();
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
                return;

            case BehaviorInterface::RETURN_BOOLEAN:
                return false;
        }
    }

    /**
     * @return ProviderBag|ProviderBagInterface
     */
    public function getProviderBag()
    {
        return $this->providerBag;
    }
}
