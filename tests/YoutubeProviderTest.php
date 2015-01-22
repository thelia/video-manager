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

namespace Thelia\VideoManager\Tests;

use Thelia\VideoManager\Provider\YoutubeProvider;

/**
 * Class YoutubeProviderTest
 * @package Thelia\VideoManager\Tests
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
class YoutubeProviderTest extends \PHPUnit_Framework_TestCase
{
    const VALID_YOUTUBE_URL = "https://www.youtube.fr/watch?v=xHtnrtPg0LI";

    public function testParseUrl()
    {
        $provider = new YoutubeProvider();

        $this->assertTrue($provider->handleUrl(static::VALID_YOUTUBE_URL));
        $this->assertFalse($provider->handleUrl("foobar"));
        $this->assertFalse($provider->handleUrl("https://www.youtube.com/watch"));

        $this->assertEquals(
            "https://www.youtube.com/watch?v=xHtnrtPg0LI",
            $provider->getLinkToVideo(static::VALID_YOUTUBE_URL)
        );

        $this->assertEquals(
            '<iframe width="560" height="315" src="//www.youtube.com/embed/xHtnrtPg0LI?rel=0" frameborder="0" allowfullscreen></iframe>',
            $provider->getVideoPlayerWidget(static::VALID_YOUTUBE_URL)
        );
    }
}
