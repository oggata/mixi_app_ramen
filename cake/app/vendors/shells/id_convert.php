<?php

require_once(BASE_DIR.'/cake/app/controllers/components/opensocial_get_user.php');
require_once(BASE_DIR.'/cake/app/controllers/components/JSON.php');

class IdConvertShell extends Shell {

  var $uses = array('IdConvert');
  //select count(*) from members where mixi_account_id = 0;
  function main(){
    /* 実際の処理を書きます */
    /* $this->uses に追加したモデルが使用できます */
    ///usr/bin/php /var/www/html/shirotouch/cake/cake/console/cake.php id_convert -app /var/www/html/shirotouch/cake/app
    echo "start";
    $datas = $this->IdConvert->select_members();
    foreach($datas as $data){
      $mixi_account_id = 1;
      $odata = $this->oauth_get_user_account($data['members']['mixi_account_code']);
      $mixi_account_id = $odata['platformUserId'];
      echo $data['members']['member_name'].'('.$data['members']['member_code'].')->'.$odata['nickname'].'('.$odata['platformUserId'].')';
      echo "\r\n";
      $this->IdConvert->update_member_id($data['members']['member_code'],$mixi_account_id);
    }
    echo "end";
  }

  function oauth_get_user_account($mixi_account_code){
    $api = new OpensocialGetUserRestfulAPI($mixi_account_code);
    $data = $api->get();
    $json = new Services_JSON;
    $decode_data = $json->decode($data,true);

    //var_dump($decode_data);

    $user_data['nickname'] = $decode_data->entry->nickname;
    $user_data['platformUserId']= 0;
    $user_data['platformUserId']= $decode_data->entry->platformUserId;
    return $user_data;
  }

}