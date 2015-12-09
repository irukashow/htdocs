<?php
    // 初期値
    $y = date('Y');
    $m = date('n');

    // 日付の指定がある場合
    if(!empty($_GET['date']))
    {
            $arr_date = explode('-', $_GET['date']);

            if(count($arr_date) == 2 and is_numeric($arr_date[0]) and is_numeric($arr_date[1]))
            {
                    $y = (int)$arr_date[0];
                    $m = (int)$arr_date[1];
            }
    }

    // 祝日の取得の関数
    function japan_holiday($y = '') {
        /**
        // カレンダーID 
        $calendar_id = urlencode('japanese__ja@holiday.calendar.google.com');

        // 取得期間
        $start  = date($y."-01-01\T00:00:00\Z");
        $end = date($y."-12-31\T00:00:00\Z");

        $url = "https://www.google.com/calendar/feeds/{$calendar_id}/public/basic?start-min={$start}&start-max={$end}&max-results=30&alt=json";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ;
        $result = curl_exec($ch);
        curl_close($ch);

        if (!empty($result)) {
            $json = json_decode($result, true);
            if (!empty($json['feed']['entry'])) {
                $datas = array();
                foreach ($json['feed']['entry'] as $val) {
                    $date = preg_replace('#\A.*?(2\d{7})[^/]*\z#i', '$1', $val['id']['$t']);
                    $datas[$date] = array(
                        'date' => preg_replace('/\A(\d{4})(\d{2})(\d{2})/', '$1/$2/$3', $date),
                        'title' => $val['title']['$t'],
                    );
                }   
                ksort($datas);
                return $datas;
            }
        }
         * 
         */

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

    // 祝日取得
    $national_holiday = japan_holiday($y);
    
    ?>
