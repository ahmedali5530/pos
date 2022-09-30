<?php


namespace App\Core\Dto\Common\Common;

use Carbon\Carbon;
use \DateTimeInterface;
use \DateTime;
use \Exception;

class DateTimeDto
{
    public ?DateTimeInterface $datetime;

    public static function createFromDateTime($datetime): ?self
    {
        if($datetime === null || (is_string($datetime) && trim($datetime) === '')){
            return null;
        }

        $dto = new self();
        try {
            if($datetime instanceof DateTimeInterface){
                $date = $datetime;
            }else {
                $date = new DateTime($datetime);
            }

//            $date->setTimezone(new DateTimeZone('utc'));

            $dto->datetime = $date;
            return $dto;

        }catch (Exception $exception) {
            return null;
        }
    }

    public static function createFromCarbon($datetime): ?self
    {
        if($datetime === null){
            return null;
        }

        $dto = new self();
        try {
            $dto->datetime = Carbon::parse($datetime/*, 'utc'*/);

            return $dto;
        }catch (Exception $exception) {
            return null;
        }
    }

    public static function parseWithCarbon($datetime): ?Carbon
    {
        if($datetime === null){
            return null;
        }

        try{
            return Carbon::parse($datetime, /*'utc'*/);
        }catch (Exception $exception){
            return null;
        }
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDatetime(): ?DateTimeInterface
    {
        return $this->datetime;
    }

    /**
     * @param DateTimeInterface|null $datetime
     */
    public function setDatetime(?DateTimeInterface $datetime): void
    {
        $this->datetime = $datetime;
    }
}
