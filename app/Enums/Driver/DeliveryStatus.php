<?php

namespace App\Enums\Driver;

enum DeliveryStatus: string
{
    case AVAILABLE = "AVAILABLE";
    case NOT_AVAILABLE = "NOT_AVAILABLE";
    case BUSY = "BUSY";
}
