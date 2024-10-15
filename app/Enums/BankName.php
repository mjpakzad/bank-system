<?php

namespace App\Enums;

enum BankName: string
{
    case ANSAR = 'بانک انصار';
    case PASARGAD = 'بانک پاسارگاد';
    case IRAN_ZAMIN = 'بانک ایران زمین';
    case SHAHR = 'بانک شهر';
    case PARSIAN = 'بانک پارسیان';
    case TOSSE_TAAVON = 'بانک توسعه تعاون';

    public function prefixes(): array
    {
        return match ($this) {
            self::ANSAR => ['627381'],
            self::PASARGAD => ['502229'],
            self::IRAN_ZAMIN => ['505785'],
            self::SHAHR => ['502806'],
            self::PARSIAN => ['622106', '639194'],
            self::TOSSE_TAAVON => ['502908'],
        };
    }
}
