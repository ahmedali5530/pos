<?php


namespace App\Core\Dto\Common\Common;

use Carbon\Carbon;
use \DateTimeInterface;
use \DateTime;
use \Exception;
use \DateTimeZone;

class DateTimeDto
{
    public static function createFromDateTime($datetime): ?DateTimeInterface
    {
        if($datetime === null){
            return null;
        }

        try {
            $date = new DateTime($datetime);
            $date->setTimezone(new DateTimeZone('utc'));

            return $date;

        }catch (Exception $exception) {
            return null;
        }
    }

    public static function createFromCarbon($datetime): ?DateTimeInterface
    {
        if($datetime === null){
            return null;
        }

        try {
            return Carbon::parse($datetime, 'utc');
        }catch (Exception $exception) {
            return null;
        }
    }
}