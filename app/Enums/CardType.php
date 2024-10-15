<?php

namespace App\Enums;

enum CardType: string
{
    case CHECKING = 'جاری';
    case SAVING = 'قرض الحسنه';
    case SHORT_TERM = 'کوتاه مدت';
    case LONG_TERM = 'بلند مدت';
}
