<?php

namespace App\Enums;

enum OrderStatus
{
    case DELIVERED;
    case CREATED;
    case PICKED;
    case CANCELED;
}
