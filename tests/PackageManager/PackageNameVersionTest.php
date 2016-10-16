<?php

/*
 * This file is part of the Yosymfony\Spress.
 *
 * (c) YoSymfony <http://github.com/yosymfony>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yosymfony\Spress\tests\PackageManager;

use Yosymfony\Spress\PackageManager\PackageNameVersion;

class PackageNameVersionTest extends \PHPUnit_Framework_TestCase
{
    public function testNameVersionPair()
    {
        $packagePair = new PackageNameVersion('vendor/foo 2.0');

        $this->assertEquals('vendor/foo', $packagePair->getName());
        $this->assertEquals('2.0', $packagePair->getVersion());
        $this->assertEquals('vendor/foo 2.0', $packagePair->getNormalizedNameVersion());
    }

    public function testColonAsVersionSeperator()
    {
        $packagePair = new PackageNameVersion('vendor/foo:2.0');

        $this->assertEquals('vendor/foo', $packagePair->getName());
        $this->assertEquals('2.0', $packagePair->getVersion());
        $this->assertEquals('vendor/foo 2.0', $packagePair->getNormalizedNameVersion());
    }

    public function testEqualAsVersionSeperator()
    {
        $packagePair = new PackageNameVersion('vendor/foo=2.0');

        $this->assertEquals('vendor/foo', $packagePair->getName());
        $this->assertEquals('2.0', $packagePair->getVersion());
        $this->assertEquals('vendor/foo 2.0', $packagePair->getNormalizedNameVersion());
    }
}