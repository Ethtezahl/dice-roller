<?php
namespace Ethtezahl\DiceRoller;

use Exception;
use InvalidArgumentException;

final class CupFactory
{
    public function newInstance(string $pAsked = '')
    {
        $cup = new Cup();

        if ('' === $pAsked) {
            return $cup;
        }

        $parts = explode('+', $pAsked);

        foreach ($parts as $element) {
            $cup->addGroup($this->analyze($element));
        }

        return $cup;
    }

    private function analyze(string $pStr)
    {
        $pattern = "/[d-]/";
        $tmp = preg_split($pattern, $pStr);
        $cnt = count($tmp);
        //TODO add validation

        if ($cnt >= 2) {

            $number = $tmp[0];
            $sides = $tmp[1];
    
            if (!$number) {
                $number = 1;
            }
    
            return new Group($number, $sides);
        } else {
            throw new InvalidArgumentException("Invalid dice notation. Check https://en.wikipedia.org/wiki/Dice_notation for valid strings.");
        }
    }
}
