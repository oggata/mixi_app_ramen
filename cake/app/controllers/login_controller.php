<?php

require_once(BASE_DIR.'/cake/app/controllers/components/opensocial_get_user.php');
require_once(BASE_DIR.'/cake/app/controllers/components/JSON.php');

class LoginController extends AppController{

  var $uses = array('Members','Product','SalesHistory');
  var $comment = array();

  function mmake(){
    $this->render($layout='mmake',$file='Noheader');
  }

  function mmake_execute(){
    $account_code = $this->params['data']['account_code'];
    $name = $this->params['data']['name'];
    $town_code_data = $this->Members->select_member_town_taste_rand_one();
    if(count($town_code_data)==0){
      $town_code = 1;
    }else{
      $town_code = $town_code_data[0]['member_town_taste']['member_code'];
    }
    $this->Members->insert_members($account_code,$name,'',$town_code);
    $this->render($layout='mmake',$file='Noheader');
  }

  function mlogin(){
    $this->render($layout='mlogin',$file='Noheader');
  }

  function top(){
  }

  function login_m(){
    //初回登録時
    $mixi_account_code = $this->params['data']['account_code'];
    $mixi_name = 'aaaa';
    $this->Session->write("after_login_flag",1);
    if(strlen($mixi_account_code)==0){
      self::s_t_out();
    }
    $this->Session->write("RefleshImgFlag",1);
    //アカウント名を取得
    //$user_data = $this->oauth_get_user_account($mixi_account_code);
    $mixi_name = 'AAAA';
    $mixi_name = mysql_escape_string($mixi_name);
    $mixi_thumbnail = 'http://test/A.jpg';
    $this->Session->write("mixi_name",$mixi_name);
    $this->Session->write("mixi_account_code",$mixi_account_code);
    $this->Session->write("mixi_thumbnail",$user_data['thumbnailUrl']);
    //既にログインIDが登録されているかチェックする
    $m_data = $this->Members->login_check($mixi_account_code);
    $member_count = $m_data[0][0]['count'];
    //ログインIDがなければ作成、あればログイン処理を行う
    if($member_count == 0){
      $town_code_data = $this->Members->select_member_town_taste_rand_one();
      $town_code = $town_code_data[0]['member_town_taste']['member_code'];
      $town_name = $town_code_data[0]['member_town_taste']['member_name'];
      $this->Members->insert_members($mixi_account_code,$mixi_account_id,$mixi_name,$mixi_thumbnail,$town_code);
      $mdata = $this->Members->select_autoincrement_member_code();
      $member_code = $mdata[0][0]['id_num'];
      $this->SalesHistory->insert_sales_hisotry($member_code,$mixi_name,$town_code,$town_name,0,0,0);
      $this->Session->write("MemberCode",$member_code);
      self::login_f_mixi();
      //self::login_f_mixi();
    }else{
      //使用者名称をアップデートする
      if(strlen($mixi_name)>0){
      //$this->Members->update_mixi_login_name($mixi_account_code,$mixi_name,$mixi_thumbnail);
    }
      //使用者情報を取得する
      $data = $this->Members->get_login_data_mixi($mixi_account_code);
      if(is_null($data[0]) == '1'){
        self::login_failed();
      }else{
        $this->Session->write("member_info",$data[0]['members']);
        self::login_success();
      }
    }
  }

  function mixi_login(){
    //初回登録時
    $mixi_account_code = $this->params['form']['id'];
    $mixi_name = $this->params['form']['name'];
    if(strlen($mixi_account_code)==0){
      self::s_t_out();
    }
    $this->Session->write("RefleshImgFlag",1);
    //アカウント名を取得
    $user_data = $this->oauth_get_user_account($mixi_account_code);
    $mixi_name = $user_data['nickname'];
    $mixi_name = mysql_escape_string($mixi_name);
    $mixi_thumbnail = $user_data['thumbnailUrl'];
    $mixi_account_id = $user_data['platformUserId'];
    $this->Session->write("after_login_flag",1);
    $this->Session->write("mixi_name",$mixi_name);
    $this->Session->write("mixi_account_code",$mixi_account_code);
    $this->Session->write("mixi_thumbnail",$user_data['thumbnailUrl']);
    //既にログインIDが登録されているかチェックする
    $m_data = $this->Members->login_check($mixi_account_code);
    $member_count = $m_data[0][0]['count'];
    //ログインIDがなければ作成、あればログイン処理を行う
    if($member_count == 0){
      $town_code_data = $this->Members->select_member_town_taste_rand_one();
      $town_code = $town_code_data[0]['member_town_taste']['member_code'];
      $town_name = $town_code_data[0]['member_town_taste']['member_name'];
      $this->Members->insert_members($mixi_account_id,$mixi_name,$mixi_thumbnail,$town_code);
      $mdata = $this->Members->select_autoincrement_member_code();
      $member_code = $mdata[0][0]['id_num'];
      $this->SalesHistory->insert_sales_hisotry($member_code,$mixi_name,$town_code,$town_name,0,0,0);
      $this->Session->write("MemberCode",$member_code);
      self::login_f_mixi();
    }else{
      //使用者名称をアップデートする
      if(strlen($mixi_name)>0){
        $this->Members->update_mixi_login_name($mixi_account_code,$mixi_account_id,$mixi_name,$mixi_thumbnail);
      }
      //使用者情報を取得する
      $data = $this->Members->get_login_data_mixi($mixi_account_code);
      if(is_null($data[0]) == '1'){
        self::login_failed();
      }else{
        $this->Session->write("member_info",$data[0]['members']);
        self::login_success();
      }
    }
  }
  //初回のラーメンを作成する
  private function make_default_product($member_code){
    $this->Product->insert_default_product($member_code);
    $pdata = $this->Product->select_autoincrement_product_code();
    $product_code = $pdata[0][0]['id_num'];
    //初回作成時、デフォルトの商品コードをアップデートする
    $this->SalesHistory->update_sales_history_main_product_code($member_code,$product_code);
    $rc = mkdir(TOP_IMG_DIR.'/top/'.$member_code, 0777);
    if (!copy(IMG_DIR.'/default_product.png', TOP_IMG_DIR.'/top/'.$member_code.'/'.$product_code.'.png')) {
        echo "failed to copy $file...\n";
    }
    if (!copy(IMG_DIR.'/ojisan_1_B.png', TOP_IMG_DIR.'/top/'.$member_code.'/ojisan_1_B.png')) {
        echo "failed to copy $file...\n";
    }
    if (!copy(IMG_DIR.'/ojisan_1_L.png', TOP_IMG_DIR.'/top/'.$member_code.'/ojisan_1_L.png')) {
        echo "failed to copy $file...\n";
    }
    if (!copy(IMG_DIR.'/ojisan_1_R.png', TOP_IMG_DIR.'/top/'.$member_code.'/ojisan_1_R.png')) {
        echo "failed to copy $file...\n";
    }
    if (!copy(IMG_DIR.'/ojisan_1_T.png', TOP_IMG_DIR.'/top/'.$member_code.'/ojisan_1_T.png')) {
        echo "failed to copy $file...\n";
    }
    $this->Members->update_main_product($member_code,$product_code);
  }

  function oauth_get_user_account($mixi_account_code){
    $api = new OpensocialGetUserRestfulAPI($mixi_account_code);
    $data = $api->get();
    $json = new Services_JSON;
    $decode_data = $json->decode($data,true);
    $user_data['nickname'] = $decode_data->entry->nickname;
    $user_data['thumbnailUrl']= $decode_data->entry->thumbnailUrl;
    $user_data['platformUserId']= $decode_data->entry->platformUserId;
    var_dump($decode_data);
    return $user_data;
  }

  function m_execute(){
       self::session_manage();
        $data = $this->Members->get_login_data($this->params['data']['e_mail'],$this->params['data']['member_password']);

    if(strlen($this->params['data']['e_mail'])==0){
      self::login_failed();
    }
       if(strlen($this->params['data']['member_password'])==0){
      self::login_failed();
    }

    if(is_null($data[0]) == '1'){
      self::login_failed();
    }else{
      $this->Session->write("member_info",$data[0]['mura_member']);
      self::login_success();
    }
  }

  function create_user(){
    $this->render($layout='create_user',$file='no_menu_default');
  }

  function create_user_confrim(){
    $this->render($layout='create_user_confrim',$file='no_menu_default');
  }

  function create_user_execute(){
    $this->Members->insert_members($mixi_account_code,$member_name);
    $this->render($layout='create_user_execute',$file='no_menu_default');
  }

  function login_failed(){
    $this->redirect('/login/login/');
  }

  function login_success(){
    $this->redirect('/top/top/');
  }

  function s_t_out(){
    $this->redirect('/login/session_timeout/');
  }

  function session_timeout(){
    $this->render($layout='session_timeout',$file='no_menu_default');
  }

  function login_f_mixi(){
    $this->redirect("/login/login_first_mixi");
  }

  function login_first_mixi(){
    $error_txt = $this->Session->read("error_txt");
    $this->set('error_txt',$error_txt);
    $member_code = $this->Session->read("MemberCode");
    $this->make_default_product($member_code);
    $this->Session->write("RefleshImgFlag",1);
    $mixi_account_code = $this->Session->read("mixi_account_code");
    $this->set('mixi_account_code',$mixi_account_code);
    $this->render($layout='login_first_mixi',$file='Noheader');
  }

  function log_out(){
    $this->Session->write("user_genre_code","");
    $this->Session->write("member_info","");
    $this->member_code = 1;
  }

  function session_manage(){
    $this->decision_date = date("Y-m-d");
    if ($this->Session->read("user_genre_code") == 1){
      $member_info = $this->Session->read("member_info");
       $this->set("login_name",$member_info['member_name']);
      $this->member_code = $member_info['clip_member_code'];
    }else{
      $this->set("login_name",'ゲスト');
      $this->member_code = 1;
    }
  }
}
