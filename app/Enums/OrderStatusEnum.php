<?php

namespace App\Enums;

enum OrderStatusEnum : int
{
    case Pending = 1;
    case Done = 2;
    case Rejected = 3;
}
