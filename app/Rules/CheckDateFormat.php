<?php

namespace App\Rules;

use Closure;
use DateTime;
use DateTimeZone;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckDateFormat implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $dateFormat = "d.m.Y";
        setlocale(LC_TIME, 'tr_TR');

        $date = DateTime::createFromFormat($dateFormat, $value);

        if ($date && $date->format($dateFormat) !== $value) {
            $fail(__('Tarih geçerli değil.'));
        }

    }
}
