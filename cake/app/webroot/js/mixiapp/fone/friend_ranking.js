	//コールバック関数
	function my_ranking_callback(response) {
		var dom = response.data;
		//最高得点を取得
		var max_count = dom.getElementsByTagName("max_count");
		var all_count = dom.getElementsByTagName("all_count");
		var ranking_max_1 = dom.getElementsByTagName("ranking_max_1");
		var ranking_all_1 = dom.getElementsByTagName("ranking_all_1");
		var all_data_count_1 = dom.getElementsByTagName("all_data_count_1");

		//得点を表示する
		document.getElementById("MY_SCORE").innerHTML = max_count[0].firstChild.nodeValue + "m";
		//ランキングを表示する
		document.getElementById("MY_RANK").innerHTML = ranking_max_1[0].firstChild.nodeValue + " / " + all_data_count_1[0].firstChild.nodeValue;
		//flashtxt.data = response.data;
	}

	//現在のランキングと得点を解析する
	//my_ranking();

	function my_ranking(){
		//XMLを取得する元
		var url = "http://mixiapp.blamestitch.com/cake/balloon/return_my_score/id:" + viewer.memberid + "/category:1/";
		var params = {};
		//HTTPメソッドの指定
		//params[gadgets.io.RequestParameters.METHOD] = gadgets.io.MethodType.GET;
		//外部サーバから得られるコンテンツの期待する形式
		params[gadgets.io.RequestParameters.CONTENT_TYPE] = gadgets.io.ContentType.DOM;
		//キャッシュする時間を設定する
		params[gadgets.io.RequestParameters.REFRESH_INTERVAL] = 0;
		//署名を付与しない
		params[gadgets.io.RequestParameters.AUTHORIZATION] = gadgets.io.AuthorizationType.NONE;
		//リクエストを送信する
		gadgets.io.makeRequest(url,my_ranking_callback,params);
	}


	//ランキングリスト
	function rankinglist(){
		//XMLを取得する元
		var url = "http://mixiapp.blamestitch.com/balloon/returnxml";
		var params = {};
		//params[gadgets.io.RequestParameters.METHOD] = gadgets.io.MethodType.GET;

		//期待するコンテンツは XML ファイル
		params[gadgets.io.RequestParameters.CONTENT_TYPE] = gadgets.io.ContentType.DOM;

		//キャッシュする時間を設定する
		params[gadgets.io.RequestParameters.REFRESH_INTERVAL] = 0;

		//署名は付与しない NONE
		params[gadgets.io.RequestParameters.AUTHORIZATION] = gadgets.io.AuthorizationType.NONE;

		gadgets.io.makeRequest(url, function(response) {

			var dom = response.data;

			//XML内の"mixi_account_name"という名前のタグ(要素)の配列を作る
			var mixi_account_name = dom.getElementsByTagName("mixi_account_name")

			//XML内の"max_count"という名前のタグ(要素)の配列を作る
			var max_count = dom.getElementsByTagName("max_count")

			//XML内の"all_count"という名前のタグ(要素)の配列を作る
			var all_count = dom.getElementsByTagName("all_count")

			//XML内の"game_count"という名前のタグ(要素)の配列を作る
			var game_count = dom.getElementsByTagName("game_count")

			//XML内の"score"という名前のタグ(要素)の配列を作る
			var scores = dom.getElementsByTagName("score");


			//tableタグを作成
			html  = '上位500人を表示中';
			html += '<table width="940" border="0" id="table-01" class="sortable"><thead><tr>';
			html += '<th class="nosort">ランク</th><th>名前</th><th>最短距離</th><th>平均距離</th><th>挑戦回数</th>';
			html += '</tr></thead><tbody>';

			for (var i=0; i<scores.length; i++){
				var rank = i + 1;
				html += '<tr><td>' + rank + '</td>';
         		html += '<td>' + mixi_account_name[i].firstChild.nodeValue + '</td>';
        		html += '<td>' + max_count[i].firstChild.nodeValue + '</td>';
        		html += '<td>' + Math.round(all_count[i].firstChild.nodeValue/game_count[i].firstChild.nodeValue)+ '</td>';
        		html += '<td>' + game_count[i].firstChild.nodeValue + '</td>';
          		html += '</tr>';
 			}

			html += '</tbody></table>';

			//divを置き換え
			document.getElementById("datalist").innerHTML = html;

		}, params);
	}