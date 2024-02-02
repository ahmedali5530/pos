<?php


namespace App\Entity;


class OrderStatus
{
    const COMPLETED = 'Completed';
    const HOLD = 'On Hold';
    const DELETED = 'Deleted';
    const DISPATCHED = 'Dispatched';
    const RETURNED = 'Returned';
    const PENDING = 'Pending';
}