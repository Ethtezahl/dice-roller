<?php
namespace Ethtezahl\DiceRoller;

use InvalidArgumentException;
use OutOfRangeException;

final class Group
{
    /**
     * @var array
     */
    private $dice;

    /**
     * @param int $pNumber Number of die
     * @param int $pSides Number of sides of each dice
     * @param string $pVariant Type of variant calculation
     */
    public function __construct(int $pNumber, int $pSides, string $pVariant = 'n')
    {
        $number = filter_var($pNumber, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        $variantPattern = "/^[LnH]$/";

        if (!$number) {
            throw new OutOfRangeException('Invalid number of die.');
        }

        if (!preg_match($variantPattern, $pVariant)) {
            throw new InvalidArgumentException('Variant roll indicator invalid.');
        }

        for ($i = 0; $i < $number; $i++) {
            $this->dice[] = new Dice($pSides);
        }
    }

    public function roll() : int
    {
        $dieArray = array();

        foreach ($this->dice as $dice) {
            array_push($dieArray, $dice->roll());
        }
        
        $sum = 0;
        return $sum;
    }
}
