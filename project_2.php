<?php
/**
 * Author:  Richard C. Ropac
 * Description:  Given a PHP array, parse this array and display
 */

// Original data
$data = [
    "Mike" => ["birthday" => "11/12/2001", "phone" => "405-123-1234", "sports" => ["basketball", "tennis"]],
    "Peter" => ["birthday" => "12/12/1995", "phone" => "405-123-1234", "sports" => ["basketball", "baseball"]],
    "Aaron" => ["birthday" => "0/10/1993", "phone" => "408-123-1234", "sports" => ["basketball", "soccer"]],
    "Joy" => ["birthday" => "5/15/1997", "phone" => "478-123-1234", "sports" => ["volleyball", "tennis"]],
    "Tina" => ["birthday" => "7/2/2000", "phone" => "512-123-1234", "sports" => ["golf", "soccer"]]
];

// Initialization of counters
$countTennis = 0;
$countPre2000 = 0;
$countAreaCode405 = 0;

// New data array
$newData = [];

foreach ($data as $name => $details) {
    // Validate the date format and values
    if (preg_match('/^(1[0-2]|0?[1-9])\/(3[01]|[12][0-9]|0?[1-9])\/\d{4}$/', $details['birthday'])) {
        $date = DateTime::createFromFormat('n/j/Y', $details['birthday']);
        $newBirthday = $date ? $date->format('d-M-Y') : 'Invalid Date';
    } else {
        $newBirthday = 'Invalid Date';
    }

    // Check for birth year before 2000
    if ($date && $date->format('Y') < 2000) {
        $countPre2000++;
    }

    // Split phone number and check area code
    $phoneParts = explode("-", $details['phone']);
    if ($phoneParts[0] == '405') {
        $countAreaCode405++;
    }

    // Add 'Swimming' to sports and check for tennis
    $sports = array_merge($details['sports'], ["Swimming"]);
    if (in_array("tennis", $details['sports'])) {
        $countTennis++;
    }

    // Add transformed data to new array
    $newData[$name] = [
        "birthday" => $newBirthday,
        "phone" => $phoneParts,
        "sports" => $sports
    ];
}

// Output the new array and counts
echo "<pre>";
print_r($newData);
echo "</pre>";

echo "Number of people own sport \"tennis\": " . $countTennis . "<br>";
echo "Number of people born before 2000: " . $countPre2000 . "<br>";
echo "Number of people with phone area code 405: " . $countAreaCode405 . "<br>";

?>