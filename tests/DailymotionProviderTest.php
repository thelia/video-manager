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

use Thelia\VideoManager\Provider\DailymotionProvider;

/**
 * Class DailymotionProviderTest
 * @package Thelia\VideoManager\Tests
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
class DailymotionProviderTest extends \PHPUnit_Framework_TestCase
{
    const VALID_DAILYMOTION_URL = "http://www.dailymotion.com/video/xcsx4y_thelia_tech";

    public function testParseUrl()
    {
        $provider = new DailymotionProvider();

        $this->assertTrue($provider->handleUrl(static::VALID_DAILYMOTION_URL));
        $this->assertFalse($provider->handleUrl("foobar"));
        $this->assertFalse($provider->handleUrl("https://dai.ly/"));

        $this->assertEquals(
            "http://www.dailymotion.com/video/xcsx4y",
            $provider->getLinkToVideo(static::VALID_DAILYMOTION_URL)
        );

        $this->assertEquals(
            '<iframe frameborder="0" width="560" height="315" src="//www.dailymotion.com/embed/video/xcsx4y" allowfullscreen></iframe>',
            $provider->getVideoPlayerWidget(static::VALID_DAILYMOTION_URL)
        );
    }
}
