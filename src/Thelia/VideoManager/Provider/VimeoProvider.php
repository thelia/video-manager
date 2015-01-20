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
 * Class VimeoProvider
 * @package Thelia\VideoManager\Provider
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
class VimeoProvider extends AbstractProvider
{
    const BASE_URL = "http://vimeo.com/";
    const BASE_EMBED_URL = "//player.vimeo.com/video/";

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
        if (!$this->handleUrl($url)) {
            $this->throwInvalidUrlException($url);
        }

        return static::BASE_URL.$this->getId($url);
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

        return static::BASE_EMBED_URL.$this->getId($url);
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

    protected function getId($url)
    {
        $data = explode("/", $url);

        return end($data);
    }

    /**
     * @return boolean
     *
     * If the provider handles the url, return true. False if not.
     */
    public function handleUrl($url)
    {
        $parsedUrl = $this->parseUrl($url);

        return preg_match("#^(www\.)?vimeo\.com$#", $parsedUrl["host"]) &&
            preg_match("#^(/[^/]+)*/\d+$#", $parsedUrl["path"])
        ;
    }

    /**
     * @return string
     *
     * Get the name of the provider. It is used to store the provider in the ProviderBag
     */
    public function getName()
    {
        return "vimeo";
    }

    /**
     * @return mixed
     */
    public function getPlayerWidth()
    {
        return $this->playerWidth;
    }

    /**
     * @param  mixed $playerWidth
     * @return $this
     */
    public function setPlayerWidth($playerWidth)
    {
        $this->playerWidth = $playerWidth;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlayerHeight()
    {
        return $this->playerHeight;
    }

    /**
     * @param  mixed $playerHeight
     * @return $this
     */
    public function setPlayerHeight($playerHeight)
    {
        $this->playerHeight = $playerHeight;

        return $this;
    }
}
