<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class OverlappingSchedule implements Rule
{
    private $schedules;

    public function __construct($schedules)
    {
        $this->schedules = $schedules;
    }

    public function passes($attribute, $value)
    {
        foreach ($this->schedules as $index => $schedule) {
            foreach ($this->schedules as $compareIndex => $compareSchedule) {
                if ($index !== $compareIndex &&
                    $schedule['day'] === $compareSchedule['day'] &&
                    (
                        ($schedule['time_from'] < $compareSchedule['time_to'] && $schedule['time_to'] > $compareSchedule['time_from']) ||
                        ($compareSchedule['time_from'] < $schedule['time_to'] && $compareSchedule['time_to'] > $schedule['time_from'])
                    )
                ) {
                    return false;
                }
            }
        }
        return true;
    }

    public function message()
    {
        return 'The schedules contain overlapping times on the same day.';
    }
}

