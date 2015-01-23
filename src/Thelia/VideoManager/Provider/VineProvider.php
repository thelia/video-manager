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
 * Class VineProvider
 * @package Thelia\VideoManager\Provider
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
class VineProvider extends AbstractProvider
{
    const MAGIC_REGEX = "#^(/v/([^/]+))(/embed)?$#";
    const BASE_URL = "https://vine.co/v/";

    protected $playerWidth;
    protected $playerHeight;
    protected $autoplayAudio;

    public function __construct($playerWidth = 600, $playerHeight = 600, $autoplayAudio = false)
    {
        $this->playerWidth = $playerWidth;
        $this->playerHeight = $playerHeight;
        $this->autoplayAudio = $autoplayAudio;
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
        $parsedUrl = $this->parseUrl($url);

        preg_match(static::MAGIC_REGEX, $parsedUrl["path"], $match);

        return static::BASE_URL . $match[2];
    }

    /**
     * @return string
     *
     * Build to embed link
     */
    public function getEmbedLinkToVideo($url)
    {
        $link = $this->getLinkToVideo($url) . "/embed/simple";

        if ($this->autoplayAudio) {
            $link .= "?audio=1";
        }

        return $link;
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
            "class" => "vine-embed",
            "src" => $this->getEmbedLinkToVideo($url),
            "width" => $this->playerWidth,
            "height" => $this->playerHeight,
            "frameborder" => "0",
        ];

        $tags = $this->createHtmlTag("iframe", '', $attributes, true);

        $scriptAttributes = [
            "async" => null,
            "src" => "//platform.vine.co/static/scripts/embed.js",
            "charset" => "utf-8",
        ];

        $tags .= $this->createHtmlTag("script", '', $scriptAttributes, true);

        return $tags;
    }

    /**
     * @return boolean
     *
     * If the provider handles the url, return true. False if not.
     */
    public function handleUrl($url)
    {
        $parsedUrl = $this->parseUrl($url);

        return "vine.co" === $parsedUrl["host"] && preg_match(static::MAGIC_REGEX, $parsedUrl["path"]);
    }

    /**
     * @return string
     *
     * Get the name of the provider. It is used to store the provider in the ProviderBag
     */
    public function getName()
    {
        return "vine";
    }

    /**
     * @return mixed
     */
    public function getPlayerWidth()
    {
        return $this->playerWidth;
    }

    /**
     * @param mixed $playerWidth
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
     * @param mixed $playerHeight
     * @return $this
     */
    public function setPlayerHeight($playerHeight)
    {
        $this->playerHeight = $playerHeight;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isAutoplayAudio()
    {
        return $this->autoplayAudio;
    }

    /**
     * @param boolean $autoplayAudio
     * @return $this
     */
    public function setAutoplayAudio($autoplayAudio)
    {
        $this->autoplayAudio = $autoplayAudio;
        return $this;
    }
}
