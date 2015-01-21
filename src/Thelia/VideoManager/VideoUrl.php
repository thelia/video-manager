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
 * Class VideoUrl
 * @package Thelia\VideoManager
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
class VideoUrl
{
    protected $url;

    /**
     * @var ProviderInterface
     */
    protected $provider;

    public function __construct($url, ProviderInterface $provider)
    {
        $this->url = $url;
        $this->provider = $provider;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param  mixed $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return ProviderInterface
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param  mixed $provider
     * @return $this
     */
    public function setProvider(ProviderInterface $provider)
    {
        $this->provider = $provider;

        return $this;
    }

    public function getVideoPlayerWidget()
    {
        return $this->provider->getVideoPlayerWidget($this->url);
    }

    public function getEmbedLink()
    {
        return $this->provider->getEmbedLinkToVideo($this->url);
    }
}
