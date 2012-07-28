<?php

class TopController extends AppController{

  var $uses = array('SalesHistory','MPrefectureTaste','MapPosition','Members','MemberMessage');

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    $message = $this->MemberMessage->select_member_message($member_code);
    $this->set('m_data',$message);
    $data = $this->Members->select_member_detail($member_code);
    $target_code = $data[0]['members']['target_code'];
    $target_id = $data[0]['members']['target_id'];
    $prefecture_code = $data[0]['members']['map_code'];
    $last_update_date = $data[0]['members']['last_update_date'];
    $town_code = $data[0]['members']['map_code'];
    $money = $data[0]['members']['money'];
    $map_code = $data[0]['members']['item_position_type_code'];
    //今訪れている町の情報を取得する
    $v_data = $this->MPrefectureTaste->select_prefecture_tasete($prefecture_code);
    $this->set('visited_town_name',$v_data[0]['member_town_taste']['member_name']);
    $this->set('visited_town_img',$v_data[0]['members']['thumnail_url']);
    $d_data = $this->Members->select_m_lv_exp($data[0]['members']['lv']);
    $dan_name =$d_data[0]['m_lv_exp']['dan_name'];
    //町ごとの評判を取得する
    $hyouka = $this->SalesHistory->select_member_town_valuation_top($member_code);
    $this->set('hyouka',$hyouka);
    $this->set('lv',$data[0]['members']['lv']);
    $this->set('lv_comment',$data[0]['members']['lv_comment']);
    $this->set('exp',$data[0]['members']['exp']);
    $this->set('least_next_exp',$data[0]['members']['least_next_exp']);
    $this->set('dan_name',$dan_name);
    $bar_length = ($data[0]['members']['exp']/($data[0]['members']['exp']+$data[0]['members']['least_next_exp']))*100;
    if ($bar_length < 0){
      $bar_length = 0;
    }
    //前回実行時間取得
    $last_xi_update_date = $data[0]['members']['last_xi_update_date'];
    //1時間後 60秒×60(分
    $added_one_hour = date("Y-m-d H:i:s", strtotime($last_xi_update_date." +3600 sec"));
    $today = date("Y-m-d H:i:s");
    //１時間後ー今の時間
    $target_date =  gmdate("H:i:s", strtotime($added_one_hour) - strtotime($today));
    $aArry=explode(":",$target_date);
    $target_hour = $aArry[0];
    $target_minute = $aArry[1];
    $target_second = $aArry[2];
    if($target_hour > 0){
      $target_minute = 0;
      $target_second = 0;
      $this->set('bottan_effect_flag','1');
    }else{
      $this->set('bottan_effect_flag','0');
    }
    //昨日を取得
    $yesterday_date = date('Y-m-d', strtotime('-1 day'));
    //最終更新日が昨日かどうかを比較して確認する
    if (strtotime($yesterday_date) > strtotime($last_xi_update_date)) {
        //echo '最終実行日は昨日です';
        $target_minute = 0;
        $target_second = 0;
        $this->set('bottan_effect_flag','1');
    }
    //イベント発生していない場合、空のテンプレート表示
    $this->set('div_template','NoAlertView');
    //最終アップデート時間より後の売上があれば表示する
    $member_town_valuation = $this->Members->select_member_town_valuation_latest($member_code,$last_update_date);
    //読込済に変更する
    $this->Members->update_member_town_valuation_after_read($member_code);
    if(count($member_town_valuation)>=1){
      $member_town_name = $member_town_valuation[0]['members']['member_name'];
      $message_txt = $member_town_valuation[0]['member_town_valuation']['title'];
      $town_human_code = $member_town_valuation[0]['member_town_valuation']['town_human_code'];
      //JavascriptのDIV内部メッセージ
      $this->set('div_color','#99CC99');
      $this->set('div_message_1',$member_town_name.'町で商品が売れました');
      $this->set('div_message_2',$message_txt.'<br><a href="/cake/tyouri/top/">その他の町の人の声を読む</a><br><br><br>');
      $this->set('div_img_url','/img/human/'.$town_human_code.'.png');
      //イベント発生時にアラート表示
      $this->set('div_template','AlertView');
    }
    //アクションフラグ
    $xi_action_flag = $this->Session->read("XiActionFlag");
    if (strlen($xi_action_flag)>0){
      //イベントが起こったときのみ発動
      $event_flag = $this->Session->read("EventFlag");
      if($event_flag == 1){
        //セッションの受取
        $event_title = $this->Session->read("EventTitle");
        $event_color = $this->Session->read("EventColor");
        $event_img = $this->Session->read("EventImg");
        $event_txt = $this->Session->read("EventTxt");
        $event_point = $this->Session->read("EventPoint");
        //セッションを初期化
        $this->Session->write("EventTitle",'');
        $this->Session->write("EventColor",'');
        $this->Session->write("EventImg",'');
        $this->Session->write("EventTxt",'');
        $this->Session->write("EventPoint",'');
        //JavascriptのDIV内部メッセージ
        $this->set('div_color',$event_color);
        $this->set('div_message_1',$event_title);
        $this->set('div_message_2',$event_txt);
        $this->set('div_img_url',$event_img);
        //イベント発生時にアラート表示
        $this->set('div_template','AlertView');
      }
      //残り時間の表示
      $target_minute = 59;
      $target_second = 59;
      $this->set('bottan_effect_flag','1');
      //サイコロの目を伝える
      $xi_number = $this->Session->read("XiNumber");
      $message = 'サイコロの目は'.$xi_number.'が出ました！<br>１時間おじさんはこの場所で屋台を開きます。';
      $alert_txt = "jAlert('".$message."', 'サイコロを振りました！');";
      $this->set('alert_txt',$alert_txt);
      //画像の更新
      $this->refresh_img($member_code,$map_code,$target_code,$prefecture_code,$bar_length,$dan_name,$data[0]['members']['least_next_exp'],$money);
      $this->set('bottan_effect_flag','0');
    }
    $after_login_flag = $this->Session->read("after_login_flag");
    $this->Session->write("after_login_flag",0);
    //ログイン直後はトップ画像を更新する
    if($after_login_flag == 1){
      $this->refresh_img($member_code,$map_code,$target_code,$prefecture_code,$bar_length,$dan_name,$data[0]['members']['least_next_exp'],$money);
    }
    $this->Session->write("XiActionFlag",'');
    $this->Session->write("XiNumber",'');
    $this->set('target_minute',$target_minute);
    $this->set('target_second',$target_second);
    $this->set('sum_exp',$data[0]['members']['sum_exp']);
    $this->set('xi_count',$data[0]['members']['last_xi_count']);
    $this->set('sales_product_count',$data[0]['members']['sales_product_count']);
    $this->set('todays_sales_product_count',$data[0]['members']['todays_sales_product_count']);
    $this->set('money',$data[0]['members']['money']);
    $time = time();
    //移動履歴
    $data = $this->SalesHistory->member_sales_list_limit_2($member_code);
    $this->set('data',$data);
    $this->set('top_img','/top_img/top/'.$member_code.'/top.jpg?'.$time);
  }

  function refresh_img($member_code,$map_code,$target_code,$prefecture_code,$bar_length,$dan_name,$least_next_lv,$money){
    $hour = intval(Date("H"));
    if(($hour >= 6) & ($hour <= 15)){
      $map_file_name = 'day';
    }else if(($hour >= 16) & ($hour <= 19)){
      $map_file_name = 'evening';
    }else{
      $map_file_name = 'night';
    }
    $im = new Imagick(IMG_DIR."/prefecture/1_".$map_file_name.".png");
    $imover = new Imagick(IMG_DIR."/cube_touch.png");
    $place = new Imagick(IMG_DIR."/over_num.png");
    for($i=1;$i<200;$i++){
      ${'position_'.$i} = new Imagick(IMG_DIR."/cube_touch.png");
    }
    $data = $this->MapPosition->select_map_position($map_code);
    foreach($data as $datas){
      ${position_.$datas['map_position']['position_code']} = new Imagick(IMG_DIR.'/'.$datas['map_position']['item_id'].'.png');
    }
    if($target_code == 29){
      $muki = '_R';
    }elseif($target_code == 23){
      $muki = '_R';
    }elseif($target_code == 16){
      $muki = '_B';
    }elseif($target_code == 24){
      $muki = '_B';
    }elseif($target_code == 31){
      $muki = '_B';
    }elseif($target_code == 39){
      $muki = '_L';
    }elseif($target_code == 45){
      $muki = '_L';
    }elseif($target_code == 52){
      $muki = '_L';
    }elseif($target_code == 58){
      $muki = '_T';
    }elseif($target_code == 51){
      $muki = '_T';
    }elseif($target_code == 43){
      $muki = '_T';
    }elseif($target_code == 36){
      $muki = '_R';
    }
    /*おじさん合成*/
    $ojisan_img = new Imagick(IMG_DIR.'/'.'ojisan_1'.$muki.'.png');
    ${'position_'.$target_code}->compositeImage($ojisan_img, imagick::COMPOSITE_OVER,0,0);
    /*おじさん合成ここまで*/
    $im->thumbnailImage(320, null);
    $imover->thumbnailImage(95, null);
    $place->thumbnailImage(320, null);
    $canvas = new Imagick();
    $width = $im->getImageWidth() + 0;
    $height = $im->getImageHeight() + 0;
    $canvas->newImage($width, $height, new ImagickPixel("white"));
    $canvas->setImageFormat("jpg");
    $canvas->compositeImage($im, imagick::COMPOSITE_OVER, 0, 0);
    $down_size = 0;
    $a = 0;
    $b = 100;
    $c = 200;
    $d = 300;
    $e = 400;
    $f = 500;
    $g = 600;
    $i = -76;
    $j = 27;
    $slide = 0;
    for($x=1;$x<14;$x++){
      if($x%2==0){
        $s=50;
      }else{
        $s=0;
      }
      $canvas->compositeImage(${position_.(7*($x-1)+1)}, imagick::COMPOSITE_OVER, $a-$s+$slide, $i+$j*($x-1)+$down_size);
      $canvas->compositeImage(${position_.(7*($x-1)+2)}, imagick::COMPOSITE_OVER, $b-$s+$slide, $i+$j*($x-1)+$down_size);
      $canvas->compositeImage(${position_.(7*($x-1)+3)}, imagick::COMPOSITE_OVER, $c-$s+$slide, $i+$j*($x-1)+$down_size);
      $canvas->compositeImage(${position_.(7*($x-1)+4)}, imagick::COMPOSITE_OVER, $d-$s+$slide, $i+$j*($x-1)+$down_size);
      $canvas->compositeImage(${position_.(7*($x-1)+5)}, imagick::COMPOSITE_OVER, $e-$s+$slide, $i+$j*($x-1)+$down_size);
    }
    //HPの長さ
    $hp_length = 280 * ($bar_length / 100) + 20;
    //HPの表示部
    $hp_bar_draw = new ImagickDraw();
    $hp_bar_draw->setFillColor("#FF6633");
    $hp_bar_draw->rectangle(20,5,$hp_length,15);
    //HPのダメージ部
    $hp_bar_draw_under = new ImagickDraw();
    $hp_bar_draw_under->setFillColor("#600000");
    $hp_bar_draw_under->rectangle(20,5,300,15);
    //背景画像の指定
    $enemy_back_ground = new ImagickDraw();
    $enemy_back_ground->setFillColor("#000000");
    $enemy_back_ground->setFillAlpha(0.5);
    $enemy_back_ground->rectangle(0,0,380,40);
    //実際に描写する
    $canvas->drawImage($enemy_back_ground);
    $canvas->drawImage($hp_bar_draw_under);
    $canvas->drawImage($hp_bar_draw);
    /*レベルの文字表記*/
    $population_font_size =12;
    $population_text_c = "#FFFFFF";
    $population_idraw = new ImagickDraw();
    $population_idraw->setFont(FONT_DIR."/msgothic.ttc");
    $population_idraw->setFontSize($population_font_size);
    $population_idraw->setFillColor($population_text_c);
    $population_idraw->annotation(20,30,''.$dan_name.'/残り:'.$least_next_lv.'Exp');
    $canvas->drawImage($population_idraw);
    $money_idraw = new ImagickDraw();
    $money_idraw->setFont(FONT_DIR."/msgothic.ttc");
    $money_idraw->setFontSize(14);
    $money_idraw->setFillColor("#FFFFFF");
    $money_idraw->annotation(10,345,'所持金'.$money.'銭');
    $canvas->drawImage($money_idraw);
    if( is_dir(TOP_IMG_DIR.'/top/'.$member_code) ){
      $canvas->writeImage(TOP_IMG_DIR.'/top/'.$member_code."/top.jpg");
    }else{
      if ( mkdir(TOP_IMG_DIR.'/top/'.$member_code,0777) ) {
        chmod(TOP_IMG_DIR.'/top/'.$member_code,0777);
        $canvas->writeImage(TOP_IMG_DIR.'/top/'.$member_code."/top.jpg");
      } else {
        echo "";
      }
    }
  }

  function message($category_code){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    if(strlen($category_code) == 0){
      $data = $this->MemberMessage->select_member_message($member_code);
    }else{
      $data = $this->MemberMessage->select_member_message_by_category($member_code,$category_code);
    }
    $this->set('data',$data);
  }

  function help(){
  }

  function help2(){
  }

  function qanda(){
  }

  function invite(){
  }

  function session_manage(){
    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['member_code'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}