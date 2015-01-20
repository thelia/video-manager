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

/**
 * Interface ProviderBagBuilder
 * @package Thelia\VideoManager
 * @author Benjamin Perche <bperche@openstudio.fr>
 *
 * This interface defines to behavior that a ProviderBagBuilder must have
 */
interface ProviderBagBuilderInterface
{
    public function createProviderBag();
}
