<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class IdentificationStatus extends Enum
{
    const EDIT =   'EDIT';
    const ACCEPT =   'ACCEPT';
    const REJECT = 'REJECT';
    const CHECK = 'CHECK';
}
