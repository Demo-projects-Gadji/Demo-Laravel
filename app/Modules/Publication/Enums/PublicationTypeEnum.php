<?php

namespace App\Modules\Publication\Enums;

enum PublicationTypeEnum: int
{
    case not_confirmed = 0;
    case active = 1;
    case blocked = 2;
}
