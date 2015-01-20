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

use Thelia\VideoManager\Provider\VimeoProvider;

/**
 * Class VimeoProviderTest
 * @package Thelia\VideoManager\Tests
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
class VimeoProviderTest extends \PHPUnit_Framework_TestCase
{
    const VALID_VIMEO_URL = "http://vimeo.com/115794083";

    public function testParseUrl()
    {
        $provider = new VimeoProvider();

        $this->assertTrue($provider->handleUrl(static::VALID_VIMEO_URL));
        $this->assertFalse($provider->handleUrl("foobar"));
        $this->assertFalse($provider->handleUrl("https://www.vimeo.com/"));

        $this->assertEquals(
            "http://vimeo.com/115794083",
            $provider->getLinkToVideo(static::VALID_VIMEO_URL)
        );

        $this->assertEquals(
            '<iframe width="560" height="315" src="//player.vimeo.com/video/115794083" frameborder="0" allowfullscreen autoplay="0"></iframe>',
            $provider->getVideoPlayerWidget(static::VALID_VIMEO_URL)
        );
    }
}
