<?php
{
    /**
     * Get data from
     * url: http://img.ignio.com/r/export/utf/xml/daily/com.xml
     * dataType: xml
     * full data for 4 days
     * start date 2019-12-18
     */

    # require config file
    require_once(dirname(__FILE__) . '/../../include/config.inc.php');


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
            foreach ($value as $dateInfo => $data) {
                $asd = (array)$data;

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
                    'date' => CHelperController::getDateFromTimestamp($createdAt)
                ],
                [
                    '$set' => [
                        'createdAt' => $createdAt,
                        'date' => CHelperController::getDateFromTimestamp($createdAt),
                        'data' => $data
                    ]
                ],
                [
                    'upsert' => true
                ]
            ]
        ];
    }

    $zodiac = new CZodiac();
    $zodiac->bulkWrite(COLL_DAILY_INFO, $bulkInfo);


}