<?php

// Simple example usage

use EventsDB\EventsDB;

require 'vendor/autoload.php';

$exampleEvents = [
    ['date' => 20180105, 'news' => 'Another event here'],
    ['date' => 20180102, 'description' => 'First event of month'],
    ['date' => 20180114, 'note' => 'Work less']
];

$calendar = EventsDB::createFromEvents($exampleEvents);
$days = $calendar->setMonth(2018, 1)->getFullMonth();

var_dump($days);
