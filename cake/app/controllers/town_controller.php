<?php

class TownController extends AppController{

  var $uses = array('MPrefecture','Procedure','Material','SalesHistory','MPrefectureTaste','Members','MemberMessage');


  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    $data = $this->SalesHistory->select_sales_history($member_code);
    $mptc = $this->MPrefectureTaste->select_count_member_taste($member_code);
    $count = $mptc[0][0]['count'];
    $this->set('data',$data);
    if($count == 0){
      $this->render($layout='top_before_make_town',$file='default');
    }else{
      $mptd = $this->MPrefectureTaste->select_member_taste($member_code);
      $this->set('town_name',$mptd[0]['member_town_taste']['member_name']);
      $this->set('mptd',$mptd);
      //今日訪れた人を集計する
      $visited_list = $this->SalesHistory->select_todays_town_visited_list($member_code);
      $this->set('visited_list',$visited_list);
      $this->render($layout='top',$file='default');
    }
  }

  function hyoka($sales_history_code){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    $sales_history_data = $this->SalesHistory->select_sales_history_detail($sales_history_code);
    $mise_member_code = $sales_history_data[0]['sales_history']['member_code'];
    //現在販売中のラーメンを選ぶ
    $data = $this->SalesHistory->select_todays_town_visited_detail($mise_member_code,$member_code);
    $this->set('data',$data);
    //現在のメインを取得
    $mdata = $this->Members->select_member_detail($mise_member_code);
    $main_product_code = $mdata[0]['members']['main_product_code'];
    $this->set('main_product_code',$main_product_code);
    $this->set('mise_member_code',$mise_member_code);
    $this->Session->write("SalesMemberCode",$mise_member_code);
    $this->Session->write("SalesHistoryCode",$sales_history_code);
  }

  function hyoka_exe(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    $mdata = $this->Members->select_member_detail($member_code);
    $member_name = $mdata[0]['members']['member_name'];
    //販売中の会員に経験値を付与
    $yatai_member_code = $this->Session->read("SalesMemberCode");
    $sales_history_code = $this->Session->read("SalesHistoryCode");
    $ydata = $this->Members->select_member_detail($yatai_member_code);
    $ymember_name = $ydata[0]['members']['member_name'];
    //既に評価済である場合はリダイレクト(不正防止)
    $h_data = $this->SalesHistory->select_sales_history_detail($sales_history_code);
    $hyoka_flag = $h_data[0]['sales_history']['hyoka_flag'];
    if ($hyoka_flag == 1){
      $this->redirect('/town/top/');
    }
    //評価された側の経験値を操作
    $hyoka = $this->params['data']['hyoka'];
    if($hyoka == 0){
      $this->Procedure->call_exp($yatai_member_code,57);
      $exp_txt = "０つ星評価＞２００EXP下降しました。";
    }elseif($hyoka == 1){
      $this->Procedure->call_exp($yatai_member_code,51);
      $exp_txt = "１つ星評価＞１００EXP下降しました。";
    }elseif($hyoka == 2){
      $this->Procedure->call_exp($yatai_member_code,52);
      $exp_txt = "２つ星評価＞EXP変化なし";
    }elseif($hyoka == 3){
      $this->Procedure->call_exp($yatai_member_code,53);
      $exp_txt = "３つ星評価＞５０EXP上昇しました。";
    }elseif($hyoka == 4){
      $this->Procedure->call_exp($yatai_member_code,54);
      $exp_txt = "４つ星評価＞１００EXP上昇しました。";
    }elseif($hyoka == 5){
      $this->Procedure->call_exp($yatai_member_code,55);
      $exp_txt = "５つ星評価＞２００EXP上昇";
    }
    $message_txt_yatai = $member_name.'さんに評価を貰いました。'.$exp_txt;
    $this->MemberMessage->insert_member_message($yatai_member_code,4,$message_txt_yatai);
    //評価した側の経験値を上昇
    $this->Procedure->call_exp($member_code,56);
    $message_txt = $ymember_name.'さんを評価しました。経験値１００ＥＸＰ上昇。';
    $this->MemberMessage->insert_member_message($member_code,3,$message_txt);
    //フラグを上げる
    $this->SalesHistory->update_hyoka_flag($sales_history_code);
    //戻る
    $this->redirect('/town/top/');
  }

  function sales_rank(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    $data = $this->SalesHistory->member_sales_list($member_code);
    $this->set('data',$data);
  }

  function buy_rank(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    $data = $this->SalesHistory->member_buy_list($member_code);
    $this->set('data',$data);
  }

  function give_exp($give_member_code){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
  }

  function q1(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    $data = $this->Members->select_member_detail($member_code);
    $member_name = $data[0]['members']['member_name'];
    $this->set('member_name',$member_name);
    $mpt = $this->MPrefecture->select_prefecture_list();
    $this->set('mpt',$mpt);
  }

  function q2(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    $answer_1 = $this->params['data']['answer_1'];
    $this->Session->write('Answer1',$answer_1);
  }

  function q3(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    $answer_2 = $this->params['data']['answer_2'];
    $this->Session->write('Answer2',$answer_2);

  }

  function q4(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    $answer_3 = $this->params['data']['answer_3'];
    $this->Session->write('Answer3',$answer_3);
  }

  function q5(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    $answer_4 = $this->params['data']['answer_4'];
    $this->Session->write('Answer4',$answer_4);
    //スープ
    $genre_code = 2;
    $data = $this->Material->select_parent_material_list_by_genre($genre_code);
    $this->set('data',$data);
  }

  function q6(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    $answer_5 = $this->params['data']['answer_5'];
    $this->Session->write('Answer5',$answer_5);
    //麺
    $genre_code = 3;
    $data = $this->Material->select_parent_material_list_by_genre($genre_code);
    $this->set('data',$data);
  }

  function q7(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    $data = $this->Material->select_parent_material_list_by_town();
    //$data = $this->Material->select_parent_material_list_by_genre(5);
    //var_dump($data);
    $this->set('data',$data);
    $answer_6 = $this->params['data']['answer_6'];
    $this->Session->write('Answer6',$answer_6);
  }

  function make_town(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    //セッションから選択項目を取得する
    $answer_7 = $this->params['data']['answer_7'];
    $this->Session->write('Answer7',$answer_7);
    $answer_1 = $this->Session->read('Answer1');
    $answer_2 = $this->Session->read('Answer2');
    $answer_3 = $this->Session->read('Answer3');
    $answer_4 = $this->Session->read('Answer4');
    $answer_5 = $this->Session->read('Answer5');
    $answer_6 = $this->Session->read('Answer6');
    $answer_7 = $this->Session->read('Answer7');
    $data = $this->Members->select_member_detail($member_code);
    $member_name = $data[0]['members']['member_name'];
    $town_name = $member_name;
    //A2
    $return_price = $this->return_a2_price($answer_2);
    $i = 1;
    foreach($answer_7 as $answer_7s){
      echo '--->';
      echo $answer_7s;
      $mate_d = $this->Material->select_parent_material_detail($answer_7s);
      ${'material_code_'.$i} = $mate_d[0]['parent_material']['parent_material_code'];
      ${'material_name_'.$i} = $mate_d[0]['parent_material']['parent_material_name'];
      $i = $i+1;
    }
    if($i == 2){
      $hissu_material_code1 = $material_code_1;
      $hissu_material_name1 = $material_name_1;
      $hissu_material_code2 = $material_code_1;
      $hissu_material_name2 = $material_name_1;
      $hissu_material_code3 = $material_code_1;
      $hissu_material_name3 = $material_name_1;
    }elseif($i == 3){
      $hissu_material_code1 = $material_code_1;
      $hissu_material_name1 = $material_name_1;
      $hissu_material_code2 = $material_code_2;
      $hissu_material_name2 = $material_name_2;
      $hissu_material_code3 = $material_code_2;
      $hissu_material_name3 = $material_name_2;
    }elseif($i == 4){
      $hissu_material_code1 = $material_code_1;
      $hissu_material_name1 = $material_name_1;
      $hissu_material_code2 = $material_code_2;
      $hissu_material_name2 = $material_name_2;
      $hissu_material_code3 = $material_code_3;
      $hissu_material_name3 = $material_name_3;
    }
    $data = array();
    $data['member_code'] = $member_code;
    $town_name = mysql_escape_string($town_name);
    $data['member_name'] = $town_name;
    $data['goal_men_type_code']= $answer_6;
    $data['goal_men_type_name']= $this->return_parent_material_name($answer_6);
    $data['goal_soup_type_code']= $answer_5;
    $data['goal_soup_type_name']= $this->return_parent_material_name($answer_5);
    $data['goal_product_price']= $return_price;
    $data['goal_kotteri_point']= $answer_4;
    $data['goal_volume_point']= $answer_3;
    $data['hissu_material_code1']= $hissu_material_code1;
    $data['hissu_material_name1']= $hissu_material_name1;
    $data['hissu_material_code2']= $hissu_material_code2;
    $data['hissu_material_name2']= $hissu_material_name2;
    $data['hissu_material_code3']= $hissu_material_code3;
    $data['hissu_material_name3']= $hissu_material_name3;
    $data['map_type_code']= $answer_1;
    //もし既に存在していたら削除する
    $this->MPrefectureTaste->delete_member_town_tasete($member_code);
    //インサートする
    $this->MPrefectureTaste->insert_member_town_taste($data);
    $this->redirect('/town/top/');
  }

  private function return_a2_price($a2_code){
    if($a2_code == 1){
      $return_price = 500;
    }else if($a2_code == 2){
      $return_price = 800;
    }else if($a2_code == 3){
      $return_price = 1000;
    }else if($a2_code == 4){
      $return_price = 1200;
    }else if($a2_code == 5){
      $return_price = 1500;
    }
    return $return_price;
  }

  private function return_parent_material_name($parent_material_code){
    $data = $this->Material->select_parent_material_detail($parent_material_code);
    return $data[0]['parent_material']['parent_material_name'];
  }

  function session_manage(){
    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['member_code'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}