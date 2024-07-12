<?php

namespace App\Rules;

use Closure;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;
class OnePreferredBank implements Rule
{
    public function passes($attribute, $value)
    {
        if (!is_array($value)) {
            return false; // or handle the case where $value is not an array
        }

        // Ensure at least one bank is selected
        $atLeastOneSelected = false;
        $preferredCount = 0;

        foreach ($value as $bank) {
            if ($bank['bank_preferred'] ?? false) {
                $preferredCount++;
                $atLeastOneSelected = true;
            }
        }

        // Return false if no bank is selected as preferred
        if (!$atLeastOneSelected) {
            return false;
        }

        // Only passes if at most one bank is marked as preferred
        return $preferredCount <= 1;
    }

    public function message()
    {
        return  Notification::make()
        ->title('Preferred Bank Required')
        ->body('Please select at least one bank and only one bank can be set as preferred.')
        ->warning()
        ->send();
    }
    }
