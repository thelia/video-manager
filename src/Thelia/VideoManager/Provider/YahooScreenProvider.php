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

namespace Thelia\VideoManager\Provider;

/**
 * Class YahooScreenProvider
 * @package Thelia\VideoManager\Provider
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
class YahooScreenProvider extends AbstractProvider
{
    protected $playerWidth;
    protected $playerHeight;

    public function __construct($playerWidth = 560, $playerHeight = 315)
    {
        $this->playerWidth = $playerWidth;
        $this->playerHeight = $playerHeight;
    }

    /**
     * @param $url
     * @return string
     *
     * Provides a proper link to the video.
     * It may build the URL even if there is one that is provided, to remove useless data ( target, unused query paramaeters)
     */
    public function getLinkToVideo($url)
    {
        // well ........
        return $url;
    }

    /**
     * @return string
     *
     * Build to embed link
     */
    public function getEmbedLinkToVideo($url)
    {
        // well ...
        return $url;
    }

    /**
     * @param $url
     * @return string
     * @throws \Thelia\VideoManager\Exception\NoVideoPlayerException if the service doesn't provide a video player
     *
     * Parses the url to retrieve the video player widget.
     */
    public function getVideoPlayerWidget($url)
    {
        $attributes = [
            "width" => $this->playerWidth,
            "height" => $this->playerHeight,
            "src" => $url,
            "scrolling" => "no",
            "frameborder" => "0",
            "allowfullscreen" => null,
            "allowtransparency" => null,
        ];

        return $this->createHtmlTag("iframe", null, $attributes, true);
    }

    /**
     * @return boolean
     *
     * If the provider handles the url, return true. False if not.
     */
    public function handleUrl($url)
    {
        $parsedUrl = $this->parseUrl($url);

        return preg_match("#([a-z]{2}\.)screen.yahoo.com#", $parsedUrl["host"]) && '/' !== $parsedUrl["path"];
    }

    /**
     * @return string
     *
     * Get the name of the provider. It is used to store the provider in the ProviderBag
     */
    public function getName()
    {
        return "yahoo";
    }

    /**
     * @return int
     */
    public function getPlayerWidth()
    {
        return $this->playerWidth;
    }

    /**
     * @param int $playerWidth
     * @return $this
     */
    public function setPlayerWidth($playerWidth)
    {
        $this->playerWidth = $playerWidth;
        return $this;
    }

    /**
     * @return int
     */
    public function getPlayerHeight()
    {
        return $this->playerHeight;
    }

    /**
     * @param int $playerHeight
     * @return $this
     */
    public function setPlayerHeight($playerHeight)
    {
        $this->playerHeight = $playerHeight;
        return $this;
    }
}
