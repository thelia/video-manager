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
 * Class YoutubeProvider
 * @package Thelia\VideoManager\Provider
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
class YoutubeProvider extends AbstractProvider
{
    const BASE_URL = "https://www.youtube.com/watch?v=";
    const BASE_EMBED_URL = "//www.youtube.com/embed/";

    protected $playerWidth;
    protected $playerHeight;
    protected $autoPlay;

    public function __construct($playerWidth = 560, $playerHeight = 315, $autoPlay = false)
    {
        $this->playerWidth = $playerWidth;
        $this->playerHeight = $playerHeight;
        $this->autoPlay = false;
    }

    /**
     * @param $url
     * @return string
     *
     * Provides a proper link to the video.
     */
    public function getLinkToVideo($url)
    {
        if (!$this->handleUrl($url)) {
            $this->throwInvalidUrlException($url);
        }

        $parsedUrl = parse_url($url);
        parse_str($parsedUrl["query"], $params);

        $link = static::BASE_URL.$params["v"];

        if (isset($params["list"])) {
            $link .= "&list=".$params["lists"];
        }

        return  $link;
    }

    /**
     * @return string
     *
     * Build to embed link
     */
    public function getEmbedLinkToVideo($url)
    {
        if (!$this->handleUrl($url)) {
            $this->throwInvalidUrlException($url);
        }

        $parsedUrl = $this->parseUrl($url);

        $src = static::BASE_EMBED_URL.$parsedUrl["query"]["v"]."?";
        if (isset($parsedUrl["query"]["list"])) {
            $src .= "list=".$parsedUrl["query"]["list"]."&";
        }

        if ($this->autoPlay) {
            $src .= "autoplay=1";
        }

        $src .= "rel=0";

        return $src;
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
        $attributes = array(
            "width" => $this->playerWidth,
            "height" => $this->playerHeight,
            "src" => $this->getEmbedLinkToVideo($url),
            "frameborder" => "0",
            "allowfullscreen" => null,
        );

        return $this->createHtmlTag("iframe", "", $attributes, true);
    }

    /**
     * @return boolean
     *
     * If the provider handles the url, return true. False if not.
     */
    public function handleUrl($url)
    {
        $parsedUrl = $this->parseUrl($url);

        if (false === $parsedUrl || !preg_match("/^(www\.)?youtube\.[a-z]{2,3}$/", $parsedUrl["host"])) {
            return false;
        }

        return $parsedUrl["path"] === '/watch' && isset($parsedUrl["query"]["v"]);
    }

    /**
     * @return string
     *
     * Get the name of the provider. It is used to store the provider in the ProviderBag
     */
    public function getName()
    {
        return "youtube";
    }

    /**
     * @return int
     */
    public function getPlayerHeight()
    {
        return $this->playerHeight;
    }

    /**
     * @param  int   $playerHeight
     * @return $this
     */
    public function setPlayerHeight($playerHeight)
    {
        $this->playerHeight = $playerHeight;

        return $this;
    }

    /**
     * @return int
     */
    public function getPlayerWidth()
    {
        return $this->playerWidth;
    }

    /**
     * @param  int   $playerWidth
     * @return $this
     */
    public function setPlayerWidth($playerWidth)
    {
        $this->playerWidth = $playerWidth;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isAutoPlay()
    {
        return $this->autoPlay;
    }

    /**
     * @param  boolean $autoPlay
     * @return $this
     */
    public function setAutoPlay($autoPlay)
    {
        $this->autoPlay = $autoPlay;

        return $this;
    }
}
