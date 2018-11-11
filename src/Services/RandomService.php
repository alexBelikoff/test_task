<?php
/**
 * Created by PhpStorm.
 * User: Beluha
 * Date: 11.11.2018
 * Time: 16:04
 */

namespace App\Services;


class RandomService
{
    const MIN_NUMBER = 0;
    const MAX_NUMBER = 10000;

    /**
     * @param int|null $min
     * @param int|null $max
     * @return int
     * @throws \Exception
     */
    public function getRandomNumber(?int $min = null, ?int $max = null):int
    {
        if($max < $min){
            throw new \Exception('Максимальный порого должен быть больше минимального');
        }
        $min = (is_null($min)) ? self::MIN_NUMBER : $min;
        $max = (is_null($max)) ? self::MAX_NUMBER : $max;
        return random_int($min, $max);
    }

}