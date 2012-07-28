<?php
class IdConvert extends AppModel
{
public $useTable = 'members';

  function select_members(){
    $strSql   = "select * from members where length(mixi_account_id) <= 5 limit 100 \n";
    return $this->query($strSql);
  }

  function update_member_id($member_code,$mixi_account_id){
    $strSql   = "update members set mixi_account_id = '".$mixi_account_id."' where member_code = ".$member_code." \n";
    return $this->query($strSql);
  }


}