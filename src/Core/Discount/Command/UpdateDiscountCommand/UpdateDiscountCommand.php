<?php

namespace App\Core\Discount\Command\UpdateDiscountCommand;

class UpdateDiscountCommand
{
            private $name;
        private $rate;
        private $rateType;
        public function getName()
        {
            return $this->name;
        }
        
        public function setName($field)
        {
            $this->name = $field;
            return $this;
        }        public function getRate()
        {
            return $this->rate;
        }
        
        public function setRate($field)
        {
            $this->rate = $field;
            return $this;
        }        public function getRateType()
        {
            return $this->rateType;
        }
        
        public function setRateType($field)
        {
            $this->rateType = $field;
            return $this;
        }
}