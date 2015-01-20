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
 * Class YoutubeShortProvider
 * @package Thelia\VideoManager\Provider
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
class YoutubeShortProvider extends YoutubeProvider
{
    public function getEmbedLinkToVideo($url)
    {
        if (!$this->handleUrl($url)) {
            $this->throwInvalidUrlException($url);
        }

        $parsedUrl = $this->parseUrl($url);

        $src = "//www.youtube.com/embed".$parsedUrl["path"]."?";
        if (isset($parsedUrl["query"]["list"])) {
            $src .= "list=".$parsedUrl["query"]["list"]."&";
        }

        $src .= "rel=0";

        return $src;
    }

    public function getLinkToVideo($url)
    {
        if (!$this->handleUrl($url)) {
            $this->throwInvalidUrlException($url);
        }

        $parsedUrl = parse_url($url);

        $link = "https://youtu.be".$parsedUrl["path"];

        if (isset($params["list"])) {
            $link .= "?list=".$params["lists"];
        }

        return $link;
    }

    /**
     * @return boolean
     *
     * If the provider handles the url, return true. False if not.
     */
    public function handleUrl($url)
    {
        $parsedUrl = $this->parseUrl($url);

        return false !== $parsedUrl && preg_match("/^(www\.)?youtu.be$/", $parsedUrl["host"]) && '/' !== $parsedUrl["path"];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "youtube-short";
    }
}
