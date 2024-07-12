<?php

namespace App\Enums;

enum ApprovelStatus: string
{
    case PROCESSING = 'processing';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
