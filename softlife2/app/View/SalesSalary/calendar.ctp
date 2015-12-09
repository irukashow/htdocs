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
	function japan_holiday($y = '')
	{
	    // カレンダーID
	    $calendar_id = urlencode('japanese__ja@holiday.calendar.google.com');
	
	    // 取得期間
	    $start  = date("$y-01-01\T00:00:00\Z");
	    $end = date("$y-12-31\T00:00:00\Z");
	
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
	}
	
	// 祝日取得
	$national_holiday = japan_holiday($y);
?>