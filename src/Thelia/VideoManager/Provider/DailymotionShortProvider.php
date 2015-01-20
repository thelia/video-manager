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
 * Class DailymotionShortProvider
 * @package Thelia\VideoManager\Provider
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
class DailymotionShortProvider extends DailymotionProvider
{
    const BASE_URL = "http://dai.ly/";

    public function handleUrl($url)
    {
        $parsedUrl = $this->parseUrl($url);

        return false !== $parsedUrl && (
            preg_match("/^(www\.)?dai\.ly$/", $parsedUrl["host"]) &&
            ($this->isVideo($parsedUrl["path"]) || $this->isPlaylist($parsedUrl["path"]))
        );
    }

    public function getName()
    {
        return "dailymotion-short";
    }
}
