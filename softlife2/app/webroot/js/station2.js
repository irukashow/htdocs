var xml = {};
// 路線検索①
function setMenuItem1(type,code){

	var s = document.getElementsByTagName("head")[0].appendChild(document.createElement("script"));
	s.type = "text/javascript";
	s.charset = "utf-8";

	var optionIndex0 = document.form.elements['data[StuffMaster][s0_1]'].options.length;	//沿線のOPTION数取得
	var optionIndex1 = document.form.elements['data[StuffMaster][s1_1]'].options.length;	//駅のOPTION数取得
	//var optionIndex2 = document.form.data[StuffMaster][s2_1].options.length;	//駅のOPTION数取得

	if (type == 0){
		for ( i=0 ; i <= optionIndex0 ; i++ ){document.form.elements['data[StuffMaster][s0_1]'].options[0]=null;}	//沿線削除
		for ( i=0 ; i <= optionIndex1 ; i++ ){
			document.form.elements['data[StuffMaster][s1_1]'].options[0]=null;
			document.form.elements['data[StuffMaster][s2_1]'].options[0]=null;
		}	//駅削除
		document.form.elements['data[StuffMaster][s1_1]'].options[0] = new Option("----",0);	//駅OPTIONを空に
		document.form.elements['data[StuffMaster][s2_1]'].options[0] = new Option("----",0);	//駅OPTIONを空に

		if (code == 0){
			document.form.elements['data[StuffMaster][s0_1]'].options[0] = new Option("----",0);	//沿線OPTIONを空に
		}else{
			s.src = "http://www.ekidata.jp/api/p/" + code + ".json";	//沿線JSONデータURL
		}
	}else{
		for ( i=0 ; i <= optionIndex1 ; i++ ){
			document.form.elements['data[StuffMaster][s1_1]'].options[0]=null;
			document.form.elements['data[StuffMaster][s2_1]'].options[0]=null;
		}	//駅削除
		if (code == 0){
			document.form.elements['data[StuffMaster][s1_1]'].options[0] = new Option("----",0);	//駅OPTIONを空に
			document.form.elements['data[StuffMaster][s2_1]'].options[0] = new Option("----",0);	//駅OPTIONを空に
		}else{
			s.src = "http://www.ekidata.jp/api/l/" + code + ".json";	//駅JSONデータURL
		}
	}

	xml.onload = function(data){
		var line = data["line"];
		var station_l = data["station_l"];
		if(line != null){
			document.form.elements['data[StuffMaster][s0_1]'].options[0] = new Option("----",0);	//OPTION1番目はNull
			for( i=0; i<line.length; i++){
				ii = i + 1	//OPTIONは2番目から表示
				var op_line_name = line[i].line_name;
				var op_line_cd = line[i].line_cd;
				document.form.elements['data[StuffMaster][s0_1]'].options[ii] = new Option(op_line_name,op_line_cd);
			}
		}
		if(station_l != null){
			document.form.elements['data[StuffMaster][s1_1]'].options[0] = new Option("----",0);	//OPTION1番目はNull
			document.form.elements['data[StuffMaster][s2_1]'].options[0] = new Option("----",0);	//OPTION1番目はNull
			for( i=0; i<station_l.length; i++){
				ii = i + 1	//OPTIONは2番目から表示
				var op_station_name = station_l[i].station_name;
				var op_station_cd = station_l[i].station_cd;
				document.form.elements['data[StuffMaster][s1_1]'].options[ii] = new Option(op_station_name,op_station_cd);
				document.form.elements['data[StuffMaster][s2_1]'].options[ii] = new Option(op_station_name,op_station_cd);	//***
			}
		}
	}
}
// 路線検索②
function setMenuItem2(type,code){

	var s = document.getElementsByTagName("head")[0].appendChild(document.createElement("script"));
	s.type = "text/javascript";
	s.charset = "utf-8";

	var optionIndex0 = document.form.elements['data[StuffMaster][s0_2]'].options.length;	//沿線のOPTION数取得
	var optionIndex1 = document.form.elements['data[StuffMaster][s1_2]'].options.length;	//駅のOPTION数取得
	//var optionIndex2 = document.form.elements['data[StuffMaster][s2_2]'].options.length;	//駅のOPTION数取得

	if (type == 0){
		for ( i=0 ; i <= optionIndex0 ; i++ ){document.form.elements['data[StuffMaster][s0_2]'].options[0]=null}	//沿線削除
		for ( i=0 ; i <= optionIndex1 ; i++ ){
			document.form.elements['data[StuffMaster][s1_2]'].options[0]=null;
			document.form.elements['data[StuffMaster][s2_2]'].options[0]=null;
		}	//駅削除
		document.form.elements['data[StuffMaster][s1_2]'].options[0] = new Option("----",0);	//駅OPTIONを空に
		document.form.elements['data[StuffMaster][s2_2]'].options[0] = new Option("----",0);	//駅OPTIONを空に

		if (code == 0){
			document.form.elements['data[StuffMaster][s0_2]'].options[0] = new Option("----",0);	//沿線OPTIONを空に
		}else{
			s.src = "http://www.ekidata.jp/api/p/" + code + ".json";	//沿線JSONデータURL
		}
	}else{
		for ( i=0 ; i <= optionIndex1 ; i++ ){
			document.form.elements['data[StuffMaster][s1_2]'].options[0]=null;
			document.form.elements['data[StuffMaster][s2_2]'].options[0]=null;
		}	//駅削除
		if (code == 0){
			document.form.elements['data[StuffMaster][s1_2]'].options[0] = new Option("----",0);	//駅OPTIONを空に
			document.form.elements['data[StuffMaster][s2_2]'].options[0] = new Option("----",0);	//駅OPTIONを空に
		}else{
			s.src = "http://www.ekidata.jp/api/l/" + code + ".json";	//駅JSONデータURL
		}
	}

	xml.onload = function(data){
		var line = data["line"];
		var station_l = data["station_l"];
		if(line != null){
			document.form.elements['data[StuffMaster][s0_2]'].options[0] = new Option("----",0);	//OPTION1番目はNull
			for( i=0; i<line.length; i++){
				ii = i + 1	//OPTIONは2番目から表示
				var op_line_name = line[i].line_name;
				var op_line_cd = line[i].line_cd;
				document.form.elements['data[StuffMaster][s0_2]'].options[ii] = new Option(op_line_name,op_line_cd);
			}
		}
		if(station_l != null){
			document.form.elements['data[StuffMaster][s1_2]'].options[0] = new Option("----",0);	//OPTION1番目はNull
			document.form.elements['data[StuffMaster][s2_2]'].options[0] = new Option("----",0);	//OPTION1番目はNull
			for( i=0; i<station_l.length; i++){
				ii = i + 1	//OPTIONは2番目から表示
				var op_station_name = station_l[i].station_name;
				var op_station_cd = station_l[i].station_cd;
				document.form.elements['data[StuffMaster][s1_2]'].options[ii] = new Option(op_station_name,op_station_cd);
				document.form.elements['data[StuffMaster][s2_2]'].options[ii] = new Option(op_station_name,op_station_cd);	//***
			}
		}
	}
}
// 路線検索③
function setMenuItem3(type,code){

	var s = document.getElementsByTagName("head")[0].appendChild(document.createElement("script"));
	s.type = "text/javascript";
	s.charset = "utf-8";

	var optionIndex0 = document.form.elements['data[StuffMaster][s0_3]'].options.length;	//沿線のOPTION数取得
	var optionIndex1 = document.form.elements['data[StuffMaster][s1_3]'].options.length;	//駅のOPTION数取得
	//var optionIndex2 = document.form.elements['data[StuffMaster][s2_3]'].options.length;	//駅のOPTION数取得

	if (type == 0){
		for ( i=0 ; i <= optionIndex0 ; i++ ){document.form.elements['data[StuffMaster][s0_3]'].options[0]=null}	//沿線削除
		for ( i=0 ; i <= optionIndex1 ; i++ ){
			document.form.elements['data[StuffMaster][s1_3]'].options[0]=null;
			document.form.elements['data[StuffMaster][s2_3]'].options[0]=null;
		}	//駅削除
		document.form.elements['data[StuffMaster][s1_3]'].options[0] = new Option("----",0);	//駅OPTIONを空に
		document.form.elements['data[StuffMaster][s2_3]'].options[0] = new Option("----",0);	//駅OPTIONを空に

		if (code == 0){
			document.form.elements['data[StuffMaster][s0_3]'].options[0] = new Option("----",0);	//沿線OPTIONを空に
		}else{
			s.src = "http://www.ekidata.jp/api/p/" + code + ".json";	//沿線JSONデータURL
		}
	}else{
		for ( i=0 ; i <= optionIndex1 ; i++ ){
			document.form.elements['data[StuffMaster][s1_3]'].options[0]=null;
			document.form.elements['data[StuffMaster][s2_3]'].options[0]=null;
		}	//駅削除
		if (code == 0){
			document.form.elements['data[StuffMaster][s1_3]'].options[0] = new Option("----",0);	//駅OPTIONを空に
			document.form.elements['data[StuffMaster][s2_3]'].options[0] = new Option("----",0);	//駅OPTIONを空に
		}else{
			s.src = "http://www.ekidata.jp/api/l/" + code + ".json";	//駅JSONデータURL
		}
	}

	xml.onload = function(data){
		var line = data["line"];
		var station_l = data["station_l"];
		if(line != null){
			document.form.elements['data[StuffMaster][s0_3]'].options[0] = new Option("----",0);	//OPTION1番目はNull
			for( i=0; i<line.length; i++){
				ii = i + 1	//OPTIONは2番目から表示
				var op_line_name = line[i].line_name;
				var op_line_cd = line[i].line_cd;
				document.form.elements['data[StuffMaster][s0_3]'].options[ii] = new Option(op_line_name,op_line_cd);
			}
		}
		if(station_l != null){
			document.form.elements['data[StuffMaster][s1_3]'].options[0] = new Option("----",0);	//OPTION1番目はNull
			document.form.elements['data[StuffMaster][s2_3]'].options[0] = new Option("----",0);	//OPTION1番目はNull
			for( i=0; i<station_l.length; i++){
				ii = i + 1	//OPTIONは2番目から表示
				var op_station_name = station_l[i].station_name;
				var op_station_cd = station_l[i].station_cd;
				document.form.elements['data[StuffMaster][s1_3]'].options[ii] = new Option(op_station_name,op_station_cd);
				document.form.elements['data[StuffMaster][s2_3]'].options[ii] = new Option(op_station_name,op_station_cd);	//***
			}
		}
	}
}