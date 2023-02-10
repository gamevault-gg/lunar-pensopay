<?php

namespace Gamevault\Pensopay\Enums;

enum PaymentEnum: string
{
    case Pending = 'pending';
    case Authorized = 'authorized';
    case Captured = 'captured';
    case Refunded = 'refunded';
    case Canceled = 'canceled';
    case Rejected = 'rejected';
}
