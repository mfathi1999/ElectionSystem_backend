<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class VoterStatus extends Enum
{
    const UNAPPROVED =   'UNAPPROVED';
    const APPROVED =   'APPROVED';
    const BLOCK = 'BLOCK';
}
