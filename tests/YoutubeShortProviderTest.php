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

namespace Thelia\VideoManager\tests;

use Thelia\VideoManager\Provider\YoutubeShortProvider;

/**
 * Class YoutubeShortProviderTest
 * @package Thelia\VideoManager\Tests
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
class YoutubeShortProviderTest extends \PHPUnit_Framework_TestCase
{
    const VALID_YOUTUBE_URL = "https://youtu.be/xHtnrtPg0LI";

    public function testParseUrl()
    {
        $provider = new YoutubeShortProvider();

        $this->assertTrue($provider->handleUrl(static::VALID_YOUTUBE_URL));
        $this->assertFalse($provider->handleUrl("foobar"));
        $this->assertFalse($provider->handleUrl("https://youtube.be/"));

        $this->assertEquals(
            "https://youtu.be/xHtnrtPg0LI",
            $provider->getLinkToVideo(static::VALID_YOUTUBE_URL)
        );

        $this->assertEquals(
            '<iframe width="560" height="315" src="//www.youtube.com/embed/xHtnrtPg0LI?rel=0" frameborder="0" allowfullscreen></iframe>',
            $provider->getVideoPlayerWidget(static::VALID_YOUTUBE_URL)
        );
    }
}
