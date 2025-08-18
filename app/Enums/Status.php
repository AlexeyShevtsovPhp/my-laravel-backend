<?php

namespace App\Enums;

enum Status
{
    case DRAFT;
    case PUBLISHED;
    case ARCHIVED;

    public const DEFAULT = self::DRAFT;

    public const ADMIN = 'admin';
}
