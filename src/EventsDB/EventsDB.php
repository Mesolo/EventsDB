<?php

namespace EventsDB;

use InvalidArgumentException;

class EventsDB
{
    private $year;
    private $month;
    private $daysInMonth;
    public static $events;
    private static $dateField;

    /**
     * Sets events pulled from database as multidimensional array and return a new instance
     *
     * @param array  $events
     * @param string $dateField
     *
     * @return EventsDB
     */
    public static function createFromEvents(array $events, string $dateField = 'date'): EventsDB
    {
        static::$events = $events;
        static::$dateField = $dateField;

        return new self;
    }

    /**
     * @param int $year  Year to process
     * @param int $month Month to process
     *
     * @return EventsDB
     */
    public function setMonth(int $year, int $month): EventsDB
    {
        if ($month < 1 || $month > 12) {
            throw new InvalidArgumentException("Il mese deve essere compreso tra 1 e 12");
        }

        $this->year = $year;
        $this->month = $month;
        $this->daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        return $this;
    }

    /**
     * Process the events from database and return an associative array
     * that contains all day of the selected month. If there is an
     * event in a day, it is represented as an array, else it is
     * set as false.
     *
     * @return array
     */
    public function getFullMonth(): array
    {
        $month = [];

        $events = static::$events;

        for ($i = 1; $i <= $this->daysInMonth; $i++) {

            $day = $this->formatDate($i);
            if (isset($events[0]) && $events[0][static::$dateField] == $day) {
                $event = $events[0];
                array_splice($events, 0, 1);
            } else
                $event = false;

            $month[] = [
                'day'   => $day,
                'event' => $event
            ];

        }

        return $month;
    }

    /**
     * Format the day as Ymd
     *
     * @param int $day
     *
     * @return int
     */
    private function formatDate(int $day): int
    {
        return sprintf("%d%02d%02d", $this->year, $this->month, $day);
    }
}
