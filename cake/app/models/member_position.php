<?php
class MemberPosition extends AppModel
{
public $useTable = 'members';

  function select_member_position($member_code,$map_code){
   $strSql   = "select * from member_position where member_code = 1 and map_code = 1 \n";
    return $this->query($strSql);
  }
}

?>