<?php

namespace Gamevault\Pensopay\Enums;

Enum FacilitatorEnum: string
{
    case Creditcard = 'creditcard';
    case Viabill = 'viabill';
    case Expressbank = 'expressbank';
    case Paypal  = 'paypal';
    case Anyday  = 'anyday';
}
