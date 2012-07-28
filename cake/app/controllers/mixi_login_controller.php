<?php

require_once(BASE_DIR.'/cake/app/controllers/components/opensocial_get_user.php');
require_once(BASE_DIR.'/cake/app/controllers/components/JSON.php');

class MixiLoginController extends AppController{
  var $dealer_code;
  var $member_code;
  var $decision_date;
  var $uses = array('Members');

  function mixi_login_m(){
    self::session_manage();
  }

  function mixi_login_m_execute(){
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

  function mixi_login(){
    $mixi_account_code = $this->params['form']['id'];
    if(strlen($mixi_account_code)==0){
      self::s_t_out();
    }
    $this->Session->write("RefleshImgFlag",1);
    //アカウント名を取得
    $user_data = $this->oauth_get_user_account($mixi_account_code);
    $mixi_name = $user_data['nickname'];
    $mixi_name = mysql_escape_string($mixi_name);
    $mixi_thumbnail = $user_data['thumbnailUrl'];
    $this->Session->write("mixi_name",$mixi_name);
    $this->Session->write("mixi_account_code",$mixi_account_code);
    $this->Session->write("mixi_thumbnail",$user_data['thumbnailUrl']);
    //既にログインIDが登録されているかチェックする
    $m_data = $this->Members->login_check($mixi_account_code);
    $member_count = $m_data[0][0]['count'];
    //ログインIDがなければ作成、あればログイン処理を行う
    if($member_count == 0){
      $this->Members->insert_mura_members_mixi($mixi_account_code,$mixi_name,$mixi_thumbnail);
      $mdata = $this->Members->select_autoincrement_member_code();
      $mura_member_code = $mdata[0][0]['id_num'];
      $this->Members->insert_syoki_item($mura_member_code);
      $this->Members->insert_syoki_item2($mura_member_code);
      self::login_f_mixi();
    }else{
      //使用者名称をアップデートする
      if(strlen($mixi_name)>0){
        $this->Members->update_mixi_login_name2($mixi_account_code,$mixi_name,$mixi_thumbnail);
      }
      //使用者情報を取得する
      $data = $this->Members->get_login_data_mixi($mixi_account_code);
      if(is_null($data[0]) == '1'){
        self::login_failed();
      }else{
        $this->Session->write("member_info",$data[0]['mura_member']);
        self::login_success();
      }
    }
  }

  function oauth_get_user_account($mixi_account_code){
    $api = new OpensocialGetUserRestfulAPI($mixi_account_code);
    $data = $api->get();
    $json = new Services_JSON;
    $decode_data = $json->decode($data,true);
    $user_data['nickname'] = $decode_data->entry->nickname;
    $user_data['thumbnailUrl']= $decode_data->entry->thumbnailUrl;
    return $user_data;
  }

  function s_t_out(){
    $this->redirect('/mixi_login/session_timeout/');
  }

  function session_timeout(){
    $this->render($layout='touch_session_timeout',$file='touch_default');
  }

  function login_f_mixi(){
    $this->redirect("/mixi_login/login_first_mixi");
  }

  function login_first_mixi(){
    $error_txt = $this->Session->read("error_txt");
    $this->set('error_txt',$error_txt);
    $this->Session->write("RefleshImgFlag",1);
    $mixi_account_name = $this->Session->read("mixi_name");
    $mixi_account_code = $this->Session->read("mixi_account_code");
    $mixi_thumbnail = $this->Session->read("mixi_thumbnail");
    $this->set('mixi_account_code',$mixi_account_code);
    $this->set('mixi_account_name',$mixi_account_name);
    $this->render($layout='touch_login_first_mixi',$file='touch_default');
  }

  function login_failed(){
    $this->redirect('/mixi_login/mixi_login/');
  }

  function login_success(){
    $this->redirect('/mixi_shiro/top/');
  }

  function log_out(){
    $this->Session->write("user_genre_code","");
    $this->Session->write("member_info","");
    $this->member_code = 1;
  }

  function session_manage(){
    $this->decision_date = date("Y-m-d");
    if ($this->Session->read("user_genre_code") == 1 ){
      $member_info = $this->Session->read("member_info");
      $this->set("login_name",$member_info['member_name']);
      $this->member_code = $member_info['clip_member_code'];
    }else{
      $this->set("login_name",'ゲスト');
      $this->member_code = 1;
    }
  }
}