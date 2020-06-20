<?php

namespace App\Helper;

use Exception;

class ColorCombination
{
    public $color1, $color2, $color3;

    public function __construct()
    {
        $this->color1 = 1;
        $this->color2 = 1;
        $this->color3 = 1;
    }


    /**
     * @throws Exception
     */
    public function increment()
    {
        if($this->color3 < 4)
        {
            $this->color3++;
            return;
        }

        if($this->color2 < 4)
        {
            $this->color2++;
            $this->color3=1;
            return;
        }

        if($this->color1 < 4)
        {
            $this->color1++;
            $this->color2=1;
            $this->color3=1;
            return;
        }

        throw new Exception("Maximum number of combinations was reached");
    }

    public function isMax(): bool
    {
        if($this->color1 != 4)
        {
            return false;
        }

        if($this->color2 != 4)
        {
            return false;
        }

        if($this->color3 != 4)
        {
            return false;
        }

        return true;
    }
}
