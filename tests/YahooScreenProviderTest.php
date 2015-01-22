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

use Thelia\VideoManager\Provider\YahooScreenProvider;


/**
 * Class YahooScreenProviderTest
 * @package Thelia\VideoManager\tests
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
class YahooScreenProviderTest extends \PHPUnit_Framework_TestCase
{
    const VALID_YAHOO_SCREEN_URL = "https://fr.screen.yahoo.com/johnny-b-goode-162801505.html";

    public function testParseUrl()
    {
        $provider = new YahooScreenProvider();

        $this->assertTrue($provider->handleUrl(static::VALID_YAHOO_SCREEN_URL));
        $this->assertFalse($provider->handleUrl("foobar"));
        $this->assertFalse($provider->handleUrl("https://screen.yahoo.com/"));

        $this->assertEquals(
            "https://fr.screen.yahoo.com/johnny-b-goode-162801505.html",
            $provider->getLinkToVideo(static::VALID_YAHOO_SCREEN_URL)
        );

        $this->assertEquals(
            '<iframe width="560" height="315" src="https://fr.screen.yahoo.com/johnny-b-goode-162801505.html" scrolling="no" frameborder="0" allowfullscreen allowtransparency></iframe>',
            $provider->getVideoPlayerWidget(static::VALID_YAHOO_SCREEN_URL)
        );
    }
}
