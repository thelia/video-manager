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

use Thelia\VideoManager\Exception\InvalidUrlException;

/**
 * Class AbstractProvider
 * @package Thelia\VideoManager\Provider
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
abstract class AbstractProvider implements ProviderInterface
{
    protected static $parsedUrlCache;

    /**
     * @param $url
     * @return bool|array
     *
     * Parses an url
     */
    protected function parseUrl($url)
    {
        if (isset(static::$parsedUrlCache[$url])) {
            return static::$parsedUrlCache[$url];
        }

        $parsedUrl = parse_url($url);

        if (is_array($parsedUrl) && !isset($parsedUrl["query"])) {
            $parsedUrl["query"] = "";
        }

        if (is_array($parsedUrl) && !isset($parsedUrl["path"])) {
            $parsedUrl["path"] = "/";
        }

        if (false === $parsedUrl ||
            !isset($parsedUrl["host"]) ||
            !isset($parsedUrl["scheme"])
        ) {
            return false;
        }

        parse_str($parsedUrl["query"], $parsedUrl["query"]);

        return static::$parsedUrlCache[$url] = $parsedUrl;
    }

    protected function createHtmlTag($tagName, $inner = "", array $attributes = array(), $forceDouble = false)
    {
        $tag = "<$tagName ";

        foreach ($attributes as $name => $value) {
            $tag .= $name;

            if (null !== $value) {
                $tag .= "=\"".str_replace("\"", "\\", $value)."\"";
            }

            $tag .= " ";
        }

        if (!$forceDouble && '' !== $inner && null !== $inner) {
            $tag .= "/>";
        } else {
            $tag = rtrim($tag); // Remove last space.
            $tag .= "></$tagName>";
        }

        return $tag;
    }

    protected function throwInvalidUrlException($url)
    {
        throw new InvalidUrlException("The url '$url' is not valid");
    }
}
