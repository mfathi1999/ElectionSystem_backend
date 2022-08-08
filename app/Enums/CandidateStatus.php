<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CandidateStatus extends Enum
{
    const APPROVED =   'APPROVED';
    const UNAPPROVED =   'UNAPPROVED';
}
