<?php

namespace App\Enums;

enum Role: string
{
    case SuperAdmin = 'super_admin';
    case Admin = 'admin';
    case Member = 'member';

    public function canCreateShortUrls(): bool
    {
        return in_array($this, [self::Admin, self::Member], true);
    }
}
