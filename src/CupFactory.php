<?php
namespace Ethtezahl\DiceRoller;

use Exception;
use InvalidArgumentException;

final class CupFactory
{
    public function newInstance(string $pAsked = '')
    {
        $cup = new Cup();
        $validationPattern = "/^\d?d\d+(?>-[LH])?(?>[+-]\d?d\d+)*$/";
        
        if ('' === $pAsked) {
            return $cup;
        }

        if (!preg_match($validationPattern, $pAsked)) {
            throw new InvalidArgumentException("Invalid dice notation. Check https://en.wikipedia.org/wiki/Dice_notation for valid strings.");
        }

        $parts = explode('+', $pAsked);

        foreach ($parts as $element) {
            $cup->addGroup($this->analyze($element));
        }

        return $cup;
    }

    private function analyze(string $pStr)
    {
        $variantPattern = "/[d-]/";

        $tmp = preg_split($variantPattern, $pStr);
        $cnt = count($tmp);


        if ($cnt <= 2) {

            $number = $tmp[0];
            $sides = $tmp[1];
            
            if (!$number) {
                $number = 1;
            }
            
            return new Group($number, $sides);
        } else {
            
            $number = $tmp[0];
            $sides = $tmp[1];
            $variant = $tmp[2];

            return new Group($number, $sides, $variant);
        }
    }
}
