<?php
    // 祝日の取得の関数
    function japan_holiday($y = '') {
        //GoogleカレンダーAPIから祝日を取得
        $apiKey = 'AIzaSyDeqANnHgI0MdRN6EaMQBWAMdlBxxAaQbg';

        $holidays = array();
        $holidays_id = 'outid3el0qkcrsuf89fltf7a4qbacgt9@import.calendar.google.com'; // mozilla.org版
        //$holidays_id = 'japanese__ja@holiday.calendar.google.com'; // Google 公式版日本語
        //$holidays_id = 'japanese@holiday.calendar.google.com'; // Google 公式版英語
        $url = sprintf(
                'https://www.googleapis.com/calendar/v3/calendars/%s/events?'.
                'key=%s&timeMin=%s&timeMax=%s&maxResults=%d&orderBy=startTime&singleEvents=true',
                $holidays_id,
                $apiKey,
                $y.'-01-01T00:00:00Z' , // 取得開始日
                $y.'-12-31T00:00:00Z' , // 取得終了日
                150 // 最大取得数
        );

        if ( $results = file_get_contents($url, true )) {
                //JSON形式で取得した情報を配列に格納
                $results = json_decode($results);
                //年月日をキー、祝日名を配列に格納
                foreach ($results->items as $item ) {
                        $date = strtotime((string) $item->start->date);
                        $title = (string) $item->summary;
                        $holidays[date('Y-m-d', $date)] = $title;
                }
                //祝日の配列を並び替え
                ksort($holidays);
        }
        return $holidays; 
    }
?>