<?php
namespace Ethtezahl\DiceRoller\Test;

use Ethtezahl\DiceRoller\Cup;
use Ethtezahl\DiceRoller\CupFactory;
use InvalidArgumentException;

final class CupFactoryTest extends \PHPUnit\Framework\TestCase
{
    private $cupFactory;

    public function setUp()
    {
        $this->cupFactory = new CupFactory();
    }

    public function testInstanceNoParam()
    {
        $this->assertInstanceOf(Cup::class, $this->cupFactory->newInstance());
    }

    public function testInstanceOneGroup()
    {
        $this->assertInstanceOf(Cup::class, $this->cupFactory->newInstance('2d6'));
    }

    public function testInstanceMultipleGroups()
    {
        $this->assertInstanceOf(Cup::class, $this->cupFactory->newInstance('2d6+3d4'));
    }

    public function testRollWithSingleDice()
    {
        $cup = $this->cupFactory->newInstance('d8');

        for ($i = 0; $i < 1000; $i++) {
            $test = $cup->roll();
            $this->assertGreaterThanOrEqual(1, $test);
            $this->assertLessThanOrEqual(8, $test);
        }
    }

    public function testRollWithMultipleDice()
    {
        $cup = $this->cupFactory->newInstance('2d6+3d4');

        for ($i = 0; $i < 1000; $i++) {
            $test = $cup->roll();
            $this->assertGreaterThanOrEqual(5, $test);
            $this->assertLessThanOrEqual(24, $test);
        }
    }

    public function testInvalidDiceException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->cupFactory->newInstance('asfgsh');
    }

    public function testAcceptDropLow()
    {
        $this->assertInstanceOf(Cup::class, $this->cupFactory->newInstance('4d6-L'));
    }

    public function testDropLowResult()
    {
        $cup = $this->cupFactory->newInstance('4d6-L');

        for ($i = 0; $i < 1000; $i++) {
            $test = $cup->roll();
            $this->assertGreaterThanOrEqual(3, $test);
            $this->assertLessThanOrEqual(18, $test);
        }
    }
}
