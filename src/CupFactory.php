<?php
namespace Ethtezahl\DiceRoller;

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

        $number = $tmp[0];
        $sides = $tmp[1];

        //TODO add validation

        if (!$number) {
            $number = 1;
        }

        return new Group($number, $sides);
    }
}
