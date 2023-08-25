<?php

declare(strict_types=1);

namespace App\Task\Recurrence\TypeHandler;

use App\Task\Entity\TaskRecurrence;
use App\Task\Enum\Day;
use RuntimeException;

class BaseTypeHandler
{
    public function validateType(TaskRecurrence $recurrence, string $expectedType): void
    {
        if (!$recurrence instanceof $expectedType)
        {
            throw new RuntimeException(sprintf("Expected recurrence of type '%s' but got type '%s'.", $expectedType, $recurrence::class));
        }
    }

    /**
     * @return Day[]
     */
    protected function getWeekDaysOrdered(array $days): array
    {
        $firstDayOfWeek = $this->getFirstDayOfWeek();

        $weekDays = match ($firstDayOfWeek) {
            Day::Monday => Day::getWeekDaysMondayFirst(),
            Day::Sunday => Day::getWeekDaysSundayFirst(),
        };

        return array_filter($weekDays, static fn (Day $day) => in_array($day, $days, true));
    }

    protected function getFirstDayOfWeek(): Day
    {
        return Day::Monday;
    }
}
