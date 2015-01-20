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

use Thelia\VideoManager\Provider\DailymotionShortProvider;

/**
 * Class DailymotionShortProviderTest
 * @package Thelia\VideoManager\Tests
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
class DailymotionShortProviderTest extends \PHPUnit_Framework_TestCase
{
    const VALID_DAILYMOTION_URL = "http://dai.ly/video/xcsx4y_thelia_tech";

    public function testParseUrl()
    {
        $provider = new DailymotionShortProvider();

        $this->assertTrue($provider->handleUrl(static::VALID_DAILYMOTION_URL));
        $this->assertFalse($provider->handleUrl("foobar"));
        $this->assertFalse($provider->handleUrl("https://dai.ly/"));

        $this->assertEquals(
            "http://dai.ly/video/xcsx4y",
            $provider->getLinkToVideo(static::VALID_DAILYMOTION_URL)
        );

        $this->assertEquals(
            '<iframe frameborder="0" width="560" height="315" src="//www.dailymotion.com/embed/video/xcsx4y" allowfullscreen></iframe>',
            $provider->getVideoPlayerWidget(static::VALID_DAILYMOTION_URL)
        );
    }
}
