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

use Thelia\VideoManager\Provider\VineProvider;

/**
 * Class VineProviderTest
 * @package Thelia\VideoManager\Tests
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
class VineProviderTest extends \PHPUnit_Framework_TestCase
{
    const VALID_VINE_URL = "https://vine.co/v/OD209dwB1dz";

    public function testParseUrl()
    {
        $provider = new VineProvider();

        $this->assertTrue($provider->handleUrl(static::VALID_VINE_URL));
        $this->assertFalse($provider->handleUrl("foobar"));
        $this->assertFalse($provider->handleUrl("https://vine.co/v/"));

        $this->assertEquals(
            "https://vine.co/v/OD209dwB1dz",
            $provider->getLinkToVideo(static::VALID_VINE_URL)
        );

        $this->assertEquals(
            '<iframe class="vine-embed" src="https://vine.co/v/OD209dwB1dz/embed/simple" width="600" height="600" frameborder="0"></iframe><script async src="//platform.vine.co/static/scripts/embed.js" charset="utf-8"></script>',
            $provider->getVideoPlayerWidget(static::VALID_VINE_URL)
        );
    }
}
