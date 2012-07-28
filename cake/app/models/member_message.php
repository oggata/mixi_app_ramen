<?php
class MemberMessage extends AppModel
{
public $useTable = 'members';

  function select_member_message($member_code){
    $strSql = "select * from member_message where member_code = ".$member_code." order by member_message_code desc,message_accept_date desc limit 20 \n";
    return $this->query($strSql);
  }

  function select_member_message_by_category($member_code,$category_code){
    $strSql = "select * from member_message where member_code = ".$member_code." and message_category = ".$category_code." order by member_message_code desc,message_accept_date desc limit 20 \n";
    return $this->query($strSql);
  }

  function insert_member_message($member_code,$message_category,$message_txt){
    $strSql  = "insert into member_message(member_code,message_category,message_txt,message_accept_date)values( \n";
    $strSql .= "".$member_code.",".$message_category.",'".$message_txt."',now()) \n";
    return $this->query($strSql);
  }
}

?>