<?php

namespace App\Enums;

enum ApplicationStatus: string
{
    case INCOMPLETE = 'incompleted';
    case SUBMITTED = 'submited';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
