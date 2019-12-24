<?php

class ZIgnioController implements ZZodiacDataInterface {

    private $url = "https://ignio.com/r/export/utf/xml/daily/com.xml";
    private $rawData;
    private $parsedData;

    /**
     * @return mixed|void
     * @throws Exception
     */
    public function getZodiacData() {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = curl_exec($ch);
            curl_close($ch);

            $this->rawData = (array)simplexml_load_string($data);
        } catch (Exception $exception) {
            throw new Exception($exception);
        }
    }

    /**
     * @return mixed|void
     */
    public function parseZodiacData() {
        $mainData = [];
        $dates = [];
        foreach ($this->rawData as $key => $value) {
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

        $this->parsedData = $result;
    }

    /**
     * @return mixed|void
     */
    public function saveZodiacData() {
        $bulkInfo = [];
        foreach ($this->parsedData as $createdAt => $data) {
            $bulkInfo[] = [
                'updateOne' => [
                    [
                        'date' => ZHelperController::getDateFromTimestamp($createdAt)
                    ],
                    [
                        '$set' => [
                            'createdAt' => $createdAt,
                            'date' => ZHelperController::getDateFromTimestamp($createdAt),
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

}