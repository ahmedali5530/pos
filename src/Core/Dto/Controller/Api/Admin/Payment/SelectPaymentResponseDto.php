<?php 

namespace App\Core\Dto\Controller\Api\Admin\Payment;

use App\Core\Dto\Common\Payment\PaymentDto;
use App\Entity\Payment;

class SelectPaymentResponseDto
{
    /**
     * @var PaymentDto
     */
    private $payment = null;

    public static function createFromPayment(Payment $payment) : self
    {
        $dto = new self();

        $dto->payment = PaymentDto::createFromPayment($payment);

        return $dto;
    }

    public function setPayment($payment)
    {
        $this->payment = $payment;
    }

    public function getPayment()
    {
        return $this->payment;
    }
}
