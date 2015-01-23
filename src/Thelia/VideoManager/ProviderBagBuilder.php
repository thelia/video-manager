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

namespace Thelia\VideoManager;

use Thelia\VideoManager\Provider\DailymotionProvider;
use Thelia\VideoManager\Provider\DailymotionShortProvider;
use Thelia\VideoManager\Provider\ProviderInterface;
use Thelia\VideoManager\Provider\VimeoProvider;
use Thelia\VideoManager\Provider\VineProvider;
use Thelia\VideoManager\Provider\YahooScreenProvider;
use Thelia\VideoManager\Provider\YoutubeProvider;
use Thelia\VideoManager\Provider\YoutubeShortProvider;

/**
 * Class ProviderBagBuilder
 * @package Thelia\VideoManager
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
class ProviderBagBuilder implements ProviderBagBuilderInterface
{
    /**
     * @var ProviderBagInterface
     */
    protected $providerBag;

    public function __construct(ProviderBagInterface $providerBag = null)
    {
        $this->providerBag = $providerBag ?: new ProviderBag();

        $this->addDefaultProviders();
    }

    protected function addDefaultProviders()
    {
        $this->providerBag
            ->add(new YoutubeProvider())
            ->add(new YoutubeShortProvider())
            ->add(new DailymotionProvider())
            ->add(new DailymotionShortProvider())
            ->add(new VimeoProvider())
            ->add(new YahooScreenProvider())
            ->add(new VineProvider())
        ;
    }

    public function addProvider(ProviderInterface $provider)
    {
        $this->providerBag->add($provider);
    }

    public function createProviderBag()
    {
        return $this->providerBag;
    }
}
