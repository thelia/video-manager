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
 * Class DailymotionProvider
 * @package Thelia\VideoManager\Provider
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
class DailymotionProvider extends AbstractProvider
{
    const BASE_URL = "http://www.dailymotion.com/";
    const BASE_EMBED_URL = "//www.dailymotion.com/embed/";
    const BASE_PLAYLIST_EMBED_URL = "http://www.dailymotion.com/widget/jukebox?list[]=";

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
     * @return string
     *
     * Build to embed link
     */
    public function getEmbedLinkToVideo($url)
    {
        return $this->genericGetLink(static::BASE_EMBED_URL, $url);
    }

    /**
     * @param $url
     * @return string
     *
     * Provides a proper link to the video.
     */
    public function getLinkToVideo($url)
    {
        return $this->genericGetLink(static::BASE_URL, $url);
    }

    protected function genericGetLink($baseUrl, $url)
    {
        if (!$this->handleUrl($url)) {
            $this->throwInvalidUrlException($url);
        }

        $parsedUrl = $this->parseUrl($url);

        $this->buildLink($parsedUrl, $url, $baseUrl);

        return $baseUrl;
    }

    protected function buildLink($parsedUrl, $url, &$buildUrl)
    {
        if ($this->isVideo($parsedUrl["path"])) {
            $buildUrl .= "video/".$this->extractId($parsedUrl["path"]);

            if ($this->autoPlay) {
                $buildUrl .= "?autoPlay=1";
            }
        } elseif ($this->isPlaylist($parsedUrl["path"])) {
            $buildUrl .= "playlist/".$this->extractId($parsedUrl["path"]);

            // On a dailymotion playlist, the first launched video is the given set in the anchor
            if (isset($parsedUrl["fragment"]) && false !== strpos($parsedUrl["fragment"], "video=")) {
                $buildUrl .= "#".$parsedUrl["fragment"];
            }
        } else {
            $this->throwInvalidUrlException($url);
        }
    }

    /**
     * @param $path
     * @return mixed
     *
     * Extract the second level of the pathinfo.
     * example: /video/foo
     * return: foo
     */
    protected function extractId($path)
    {
        $data = preg_replace("#^/(video|playlist)/([a-z\d_-]+)$#", "$2", $path);
        $id = explode("_", $data)[0];

        return $id;
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
        if (!$this->handleUrl($url)) {
            $this->throwInvalidUrlException($url);
        }

        $parsedUrl = $this->parseUrl($url);

        if ($this->isVideo($parsedUrl["path"])) {
            return $this->getVideoVideoPlayerWidget($url);
        } elseif ($this->isPlaylist($parsedUrl["path"])) {
            return $this->getPlayListVideoPlayerWidget($parsedUrl["path"]);
        }

        $this->throwInvalidUrlException($url);
    }

    protected function getVideoVideoPlayerWidget($url)
    {
        $attributes = array(
            "frameborder" => "0",
            "width" => $this->playerWidth,
            "height" => $this->playerHeight,
            "src" => $this->getEmbedLinkToVideo($url),
            "allowfullscreen" => null,
        );

        return $this->createHtmlTag("iframe", "", $attributes, true);
    }

    protected function getPlayListVideoPlayerWidget($playlistPath)
    {
        $attributes = array(
            "allowtransparency" => "true",
            "marginwidth" => "0",
            "marginheight" => "0",
            "src" => static::BASE_PLAYLIST_EMBED_URL.urlencode($playlistPath),
            "skin" => "default",
            "autoplay" => (int) $this->autoPlay,
            "automute" => "0",
            "info" => "1",
            "frameborder" => "0",
            "height" => "{$this->playerHeight}px",
            "width" => "{$this->playerWidth}px",
            "align" => "middle",
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

        return false !== $parsedUrl && (
            preg_match("/^(www\.)?dailymotion\.[a-z]{2,3}$/", $parsedUrl["host"]) &&
            ($this->isVideo($parsedUrl["path"]) || $this->isPlaylist($parsedUrl["path"]))
        );
    }

    protected function isPlaylist($path)
    {
        return preg_match("#^/playlist/([a-z\d_-]+)#", $path);
    }

    protected function isVideo($path)
    {
        return preg_match("#^/video/([a-z\d_-]+)#", $path);
    }

    /**
     * @return string
     *
     * Get the name of the provider. It is used to store the provider in the ProviderBag
     */
    public function getName()
    {
        return "dailymotion";
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
