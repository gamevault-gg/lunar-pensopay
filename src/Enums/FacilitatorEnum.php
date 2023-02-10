<?php

namespace Gamevault\Pensopay\Enums;

enum FacilitatorEnum: string
{
    case Creditcard = 'creditcard';
    case Viabill = 'viabill';
    case Expressbank = 'expressbank';
    case Paypal = 'paypal';
    case Anyday = 'anyday';
}
