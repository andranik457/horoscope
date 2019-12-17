<?php

# require config file
require_once(dirname(__FILE__) . '/../analytics-dashboard/include/config.inc.php');

ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

$url="http://img.ignio.com/r/export/utf/xml/daily/com.xml";
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $url);    // get the url contents

$data = curl_exec($ch); // execute curl request
curl_close($ch);

$xml = (array)simplexml_load_string($data) or die("Error: Cannot create object");


$mainData = [];
$dates = [];
foreach ($xml as $key => $value) {
    if ($key == 'date') {
        $dateInfo = (array)$value;
        foreach ($dateInfo["@attributes"] as $dateKey => $dateValue) {
            $dates[$dateKey] = $dateValue;
        }
    }
    else {
//        var_dump($key, $value);

        foreach ($value as $dateInfo => $data) {
            $asd = (array)$data;
//            var_dump($asd[0]);

            if (!isset($mainData[$dateInfo])) {
                $mainData[$dateInfo] = [];
            }

            $mainData[$dateInfo][$key] = $asd;
        }
    }

}


$result = [];
foreach ($dates as $key => $value) {
    $createdAt = strtotime($value);
    $result[$createdAt] = [];

    foreach ($mainData[$key] as $sign => $info) {
        $result[$createdAt][$sign] = trim($info[0]);
    }
}

$bulkInfo = [];
foreach ($result as $createdAt => $data) {
    $bulkInfo[] = [
        'updateOne' => [
            [
                'date' => CHelperManager::getOnlyDateFromTime($createdAt)
            ],
            [
                '$set' => [
                    'createdAt' => $createdAt,
                    'date' => CHelperManager::getOnlyDateFromTime($createdAt),
                    'data' => $data
                ]
            ],
            [
                'upsert' => true
            ]
        ]
    ];
}
//echo "<pre>";
//var_dump($bulkInfo);
//echo "</pre>";

$helper = new CHelper();
$helper->bulkWrite('zodiac', $bulkInfo);







