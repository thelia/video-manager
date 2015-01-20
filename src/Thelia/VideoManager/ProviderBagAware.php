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
 * Class ProviderBagAware
 * @package Thelia\VideoManager
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
class ProviderBagAware
{
    /**
     * @var \Thelia\VideoManager\Provider\ProviderInterface
     */
    protected $providerBag;

    /**
     * @return \Thelia\VideoManager\Provider\ProviderInterface
     */
    public function getProviderBag()
    {
        return $this->providerBag;
    }

    /**
     * @param \Thelia\VideoManager\Provider\ProviderInterface $providerBag
     * @return $this
     */
    public function setProviderBag(ProviderInterface $providerBag)
    {
        $this->providerBag = $providerBag;
        return $this;
    }
}
