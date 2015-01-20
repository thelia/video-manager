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
use Thelia\VideoManager\Provider\VimeoProvider;
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
    }

    protected function addDefaultProviders()
    {
        $this->providerBag
            ->add(new YoutubeProvider())
            ->add(new YoutubeShortProvider())
            ->add(new DailymotionProvider())
            ->add(new DailymotionShortProvider())
            ->add(new VimeoProvider())
        ;
    }

    public function createProviderBag()
    {
        $this->addDefaultProviders();

        return $this->providerBag;
    }
}
