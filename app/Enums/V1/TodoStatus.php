<?php

namespace App\Enums\V1;

enum TodoStatus: string
{
    case Pending = 'pending';
    case Completed = 'completed';
}
