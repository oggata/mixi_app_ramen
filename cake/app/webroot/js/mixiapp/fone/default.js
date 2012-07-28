	//最初にＦＬＡＳＨを表示する
	gametop();

	//クリックでトップページ（flash）へ遷移する
	document.getElementById("top_page").onclick = function(evt) {
		delete_rankinglist();
		view_flash();
	}

	//FLASHを表示する
	function gametop(){
		gadgets.util.registerOnLoadHandler(view_flash);
	}

	//FLASHを削除する
	function delete_flash(){
		document.getElementById("externalContainer").innerHTML = '';
	}

	//クリックでランキングを表示する
	document.getElementById("ranking_page").onclick = function(evt) {
		delete_flash();
		rankinglist();
	}

	//ランキングを削除する
	function delete_rankinglist(){
		document.getElementById("datalist").innerHTML = '';
	}

	//マイミクを招待する
	document.getElementById("navi_invite").onclick = function(evt) {
		opensocial.requestShareApp(opensocial.IdSpec.PersonId.VIEWER, null, function(response) {
		});
	}

	//縦幅の設定
	var tid=setTimeout("heightset()",1000);
	function heightset(){
		//得点ＤＢを作成する
		checkaccount();
		//ランキング情報などを取得する
		my_ranking();
		//高さの調整を行なう
		gadgets.window.adjustHeight();
	}

	//FLASHを表示する
	function view_flash(){
		gadgets.flash.embedFlash("http://mixiapp.blamestitch.com/flash/balloon.swf", "externalContainer", "9.0.0",
	  		{
		 	width : 755,
		 	height : 600,
		 	quality : 'high',
		 	id : 'aexternal',
		 	wmode : 'transparent',
		 	allowScriptAccess : 'always'
	   		}
 		);
	}

	var viewer = new Object(); // globalで必要な変数を宣言
	var flashtxt = new Object(); // globalで必要な変数を宣言 flashに値を渡す

	//プロフィール情報を取得するためのメソッド
	function get_viewer_profile() {
		var request = opensocial.newDataRequest();
		request.add(request.newFetchPersonRequest(opensocial.IdSpec.PersonId.VIEWER), "viewer_data");

		request.send(
			function (response) {
				var item = response.get("viewer_data");
				if (item.hadError()) {
					// エラー処理。item.getError() で詳細情報を取得
					return;
				 }

				// 実行ユーザのプロフィールを参照
				var person = item.getData();

				viewer.memberid = person.getField(opensocial.Person.Field.ID); // ID
				viewer.nickname = person.getField(opensocial.Person.Field.NICKNAME); // ニックネーム
				viewer.sumnail = person.getField(opensocial.Person.Field.THUMBNAIL_URL);//サムネイル

				//上部ヘッダーに表示する
				document.getElementById("NICKNAME").innerHTML = viewer.nickname;
				document.getElementById("THUMBNAIL_URL").innerHTML = "<img src='" + viewer.sumnail + "' class='thumimg'>";
				document.getElementById("mixiname").innerHTML = viewer.sumnail;
			}
		);
	}

	//プロフィール情報の取得
	gadgets.util.registerOnLoadHandler(get_viewer_profile);