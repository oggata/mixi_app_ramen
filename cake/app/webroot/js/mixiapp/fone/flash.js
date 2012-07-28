	//アクティビティを送信するためのメソッド
	function sendActivity(score){
		var params = {};
		params[opensocial.Activity.Field.TITLE] = viewer.nickname + "さんが" + score + "点です";
		var activity = opensocial.newActivity(params);

		opensocial.requestCreateActivity(
		activity, opensocial.CreateActivityPriority.HIGH, function(response) {
		  if (response.hadError()) {
		    var code = response.getErrorCode();
		    test = test + 1;
		    // do something...
			//alert("1do something...");
		  } else {
		  	test = test + 1;
		    // do something...
		    //alert("2do something...");
		  }
		});
	}

	//初回にゲーム保存データを作成するメソッド
	function checkaccount(){
		//ニックネームはURLエンコードをかけないと渡らない
		var EncStr = encodeURI( viewer.nickname );
		var url = "http://mixiapp.blamestitch.com/balloon/check_account/name:" + EncStr + "/id:" + viewer.memberid + "/category:1/";
		var params = {};
		//HTTPメソッドの指定
		params[gadgets.io.RequestParameters.METHOD] = gadgets.io.MethodType.POST;
		//外部サーバから得られるコンテンツの期待する形式
		params[gadgets.io.RequestParameters.CONTENT_TYPE] = gadgets.io.ContentType.FEED;
		var post_data = {span : 7};
		params[gadgets.io.RequestParameters.POST_DATA] = gadgets.io.encodeValues(post_data);
		//署名を付与しない
		params[gadgets.io.RequestParameters.AUTHORIZATION] = gadgets.io.AuthorizationType.NONE;

		gadgets.io.makeRequest(url,callback,params);
	}


	//得点を保存するためのメソッド
	function savedatascore(score){
		//alert("score...");
		//ニックネームはURLエンコードをかけないと渡らない
		var EncStr = encodeURI( viewer.nickname );
		var url = "http://mixiapp.blamestitch.com/balloon/insert_score/id:" + viewer.memberid + "/score:" + score + "/category:1/";

		var params = {};
		//HTTPメソッドの指定
		params[gadgets.io.RequestParameters.METHOD] = gadgets.io.MethodType.POST;
		//外部サーバから得られるコンテンツの期待する形式
		params[gadgets.io.RequestParameters.CONTENT_TYPE] = gadgets.io.ContentType.FEED;
		var post_data = {span : 7};
		params[gadgets.io.RequestParameters.POST_DATA] = gadgets.io.encodeValues(post_data);
		//署名を付与しない
		params[gadgets.io.RequestParameters.AUTHORIZATION] = gadgets.io.AuthorizationType.NONE;

		gadgets.io.makeRequest(url,callback,params);
	}


	//コールバック関数
	function callback(){
	}

	//コールバック関数
	function callback2(response) {
		 var feed = response.data;
		 flashtxt.data = response.data;
	}

	//コールバック関数
	function callback3(){
		return flashtxt.data;
	}

	//これまでの得点を取得するメソッド
	function getResultHtml(){
		var EncStr = encodeURI( viewer.nickname );
		var url = "http://mixiapp.blamestitch.com/cake/balloon/return_score/id:" + viewer.memberid + "/category:1/";
		var params = {};
		//HTTPメソッドの指定
		params[gadgets.io.RequestParameters.METHOD] = gadgets.io.MethodType.POST;
		//外部サーバから得られるコンテンツの期待する形式
		params[gadgets.io.RequestParameters.CONTENT_TYPE] = gadgets.io.ContentType.TEXT;
		var post_data = {span : 7};
		params[gadgets.io.RequestParameters.POST_DATA] = gadgets.io.encodeValues(post_data);
		//署名を付与しない
		params[gadgets.io.RequestParameters.AUTHORIZATION] = gadgets.io.AuthorizationType.NONE;
		//リクエストを送信する
		gadgets.io.makeRequest(url,callback2,params);
	}