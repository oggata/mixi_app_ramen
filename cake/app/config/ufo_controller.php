<?php

App::import('Vendor', 'include_path_vendors');
App::import('Vendor', 'Zend', array('file'=>'Zend' . DS . 'Feed.php') );
App::import('Vendor', 'Zend/Rest', array('file'=>'Zend/Rest' . DS . 'Server.php') );
//App::import('Vendor', 'Zend/Mail/Transport', array('file'=>'Zend/Mail/Transport' . DS . 'Smtp.php') );

// コンポーネントをロードする
//require_once 'Zend/Feed.php';

class UfoController extends AppController{

	var $uses = array('Scores');
	var $comment = array();

	function test(){
		//echo "aaaa";
	$data = array(
			'title'       => 'UFOGAME_SCORE',
			'link'        => 'http://www.high.msn.to/',
			'charset'     => 'UTF-8',
			'description' => 'プログラミング',
			'author'      => 'High5',
			'email'       => 'high@yahoo.com',
			'entries'     => array(
					array(
						'title'        => 'フィードエントリのタイトル',
						'link'         => 'http://www.high.msn.to/entry.php?id=111',
						'description'  => 'フィードエントリの短いバージョン',
						'guid'         => '111',
						'content'      => '長いバージョン',
						'commentRss'   => 'http://www.high.msn.to/rss/coment/'
						),
					array(
						'title'        => 'フィードエントリのタイトル',
					    'link'         => 'http://www.high.msn.to/entry.php?id112',
					    'description'  => 'フィードエントリの短いバージョン',
					    'guid'         => '112',
					    'content'      => '長いバージョン',
					    'commentRss'   => 'http://www.high.msn.to/'
					    )
			)
		);

	   	$atomfeed = Zend_Feed::importArray($data);
	   	assert($atomfeed instanceof Zend_Feed_Abstract);
	   	print $atomfeed->saveXML();
	   	//$atomfeed->send();
	   	// フィードを標準出力に出力します
		$this->render($layout='test',$file='feeds');
	}

	function score(){
		//echo "aaaa";

		$datas = $this->Scores->select_ufo_game_score();

		$i = 0;
		foreach($datas as $data1){
			 $arraydata[$i]['title']				= $data1['ufo_game_score']['mixi_account_name'];
			 $arraydata[$i]['link']					= 'http://mixi.jp/run_appli.pl?id=17421';
			 $arraydata[$i]['description']			= $data1['ufo_game_score']['max_count'];
			 $arraydata[$i]['guid']					= $data1['ufo_game_score']['mixi_account_code'];
			 $arraydata[$i]['content']				= $data1['ufo_game_score']['all_count'];
			 $arraydata[$i]['commentRss']			= $data1['ufo_game_score']['max_count'];
			 $arraydata[$i]['mixi_account_name']	= $data1['ufo_game_score']['mixi_account_name'];
			 $arraydata[$i]['mixi_account_code']	= $data1['ufo_game_score']['mixi_account_code'];
			 $arraydata[$i]['all_count']            = $data1['ufo_game_score']['all_count'];
			 $arraydata[$i]['max_count']            = $data1['ufo_game_score']['max_count'];
			 $arraydata[$i]['game_count']			= $data1['ufo_game_score']['game_count'];
			 $arraydata[$i]['data_acquire_date']	= $data1['ufo_game_score']['data_acquire_date'];
			 $i++;
		}




		$data = array(
				'title'       => 'UFOGAME_SCORE',
				'link'        => 'http://www.high.msn.to/',
				'charset'     => 'UTF-8',
				'description' => 'test',
				'author'      => 'High5',
				'email'       => 'high@yahoo.com',
				'mixi_account_name' => 'aaaa',
				'entries'     => $arraydata,
		);

	   	$atomfeed = Zend_Feed::importArray($data);
	   	assert($atomfeed instanceof Zend_Feed_Abstract);
	   	print $atomfeed->saveXML();
	   	//$atomfeed->send();
	   	// フィードを標準出力に出力します
		$this->render($layout='score',$file='feeds');

	}

	function scores(){

		$feed = array(
				'title'       => 'UFOGAME_SCORE',
				'link'        => 'http://www.high.msn.to/',
				'charset'     => 'UTF-8',
				'description' => 'test',
				'author'      => 'High5',
				'email'       => 'high@yahoo.com',
				'entries'     => $array()
		);

		$datas = $this->Scores->select_ufo_game_score();

		foreach($datas as $data1){
			$feed['entries'][] = array(
				'title' => $data1['ufo_game_score']['mixi_account_name'],
				'link' => 'http://mixi.jp/run_appli.pl?id=17421',
				'description' => $data1['ufo_game_score']['max_count']
			);
		}



		$rss = Zend_Feed::importArray($feed,'rss');
		print $rss->send();

//	   	$atomfeed = Zend_Feed::importArray($data);
//	   	assert($atomfeed instanceof Zend_Feed_Abstract);
//	   	print $atomfeed->saveXML();
	   	//$atomfeed->send();
	   	// フィードを標準出力に出力します
//		$this->render($layout='score',$file='feeds');


	}





	function returnxml(){



		$server = new Zend_Rest_Server();


		//$server->handle(array('method' => 'hello',  'name' => $name ));

		$server->returnResponse(true);
		$xml = $server->handle(array('method' => 'hello',  'name' => $name ));

		$server->handle();

		$this->render($layout='score',$file='feeds');


	}




}

