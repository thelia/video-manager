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
 * Interface ProviderInterface
 * @package Thelia\VideoManager\Provider
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
interface ProviderInterface
{
    /**
     * @param $url
     * @return string
     *
     * Provides a proper link to the video.
     * It may build the URL even if there is one that is provided, to remove useless data ( target, unused query paramaeters)
     */
    public function getLinkToVideo($url);

    /**
     * @return string
     *
     * Build to embed link
     */
    public function getEmbedLinkToVideo($url);

    /**
     * @param $url
     * @return string
     * @throws \Thelia\VideoManager\Exception\NoVideoPlayerException if the service doesn't provide a video player
     *
     * Parses the url to retrieve the video player widget.
     */
    public function getVideoPlayerWidget($url);

    /**
     * @return boolean
     *
     * If the provider handles the url, return true. False if not.
     */
    public function handleUrl($url);

    /**
     * @return string
     *
     * Get the name of the provider. It is used to store the provider in the ProviderBag
     */
    public function getName();

    /**
     * @return int
     */
    public function getPlayerWidth();

    /**
     * @return int
     */
    public function getPlayerHeight();

    /**
     * @param $width
     * @return $this
     */
    public function setPlayerWidth($width);

    /**
     * @param $height
     * @return $this
     */
    public function setPlayerHeight($height);
}
