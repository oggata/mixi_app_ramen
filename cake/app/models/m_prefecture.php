<?php
class MPrefecture extends AppModel
{
public $useTable = 'member_position';

  function select_prefecture_list(){
    $strSql   = "select * from m_prefecture \n";
    return $this->query($strSql);
  }

  function select_prefecture_detail($prefecture_code){
    $strSql   = "select * from m_prefecture where prefecture_code = ".$prefecture_code." \n";
    return $this->query($strSql);
  }

  function select_city_list($prefecture_code,$member_code,$page_start_no,$page_end_no){
    $strSql   = "select \n";
    $strSql  .= "ifnull(city.city_name,'') as c_city_name,ifnull(mem.city_name,'*********') as m_city_name,ifnull(mem.city_code,'default') as m_city_code,city.prefecture_code  \n";
    $strSql  .= "from \n";
    $strSql  .= "( \n";
    $strSql  .= "select \n";
    $strSql  .= "* \n";
    $strSql  .= "from \n";
    $strSql  .= "m_city \n";
    $strSql  .= "where \n";
    $strSql  .= "prefecture_code = ".$prefecture_code." \n";
    $strSql  .= ")city \n";
    $strSql  .= "left outer join \n";
    $strSql  .= "( \n";
    $strSql  .= "select \n";
    $strSql  .= "* \n";
    $strSql  .= "from \n";
    $strSql  .= "member_city \n";
    $strSql  .= "where \n";
    $strSql  .= "member_code = ".$member_code." and prefecture_code = ".$prefecture_code." \n";
    $strSql  .= ")mem \n";
    $strSql  .= "on (city.city_code = mem.city_code) \n";
    $strSql .= " limit ".$page_start_no.",".$page_end_no."	\n";
    return $this->query($strSql);
  }

  function select_get_prefecture_list($member_code){
    $strSql   = "select \n";
    $strSql  .= "pre.prefecture_code as prefecture_code,pre.prefecture_name as prefecture_name,ifnull(mem.count,0) as count,pre.city_count as city_count \n";
    $strSql  .= "from \n";
    $strSql  .= "( \n";
    $strSql  .= "select \n";
    $strSql  .= "* \n";
    $strSql  .= "from \n";
    $strSql  .= "m_prefecture \n";
    $strSql  .= ")pre \n";
    $strSql  .= "left outer join( \n";
    $strSql  .= "select \n";
    $strSql  .= "prefecture_code,count(*) as count \n";
    $strSql  .= "from \n";
    $strSql  .= "member_city \n";
    $strSql  .= "where \n";
    $strSql  .= "member_code = ".$member_code." \n";
    $strSql  .= "group by prefecture_code \n";
    $strSql  .= ")mem on (pre.prefecture_code = mem.prefecture_code) \n";
    $strSql  .= "group by pre.prefecture_code,pre.prefecture_name,pre.prefecture_name \n";
    return $this->query($strSql);
  }

  function insert_into_m_postcode($postcode,$prefecture_name,$city_name,$town_name,$prefecture_kana,$city_kana,$town_kana){
    $strSql   = "insert into m_postcode( \n";
    $strSql  .= "postcode, \n";
    $strSql  .= "prefecture_name, \n";
    $strSql  .= "city_name, \n";
    $strSql  .= "town_name, \n";
    $strSql  .= "prefecture_kana, \n";
    $strSql  .= "city_kana, \n";
    $strSql  .= "town_kana \n";
    $strSql  .= ")values( \n";
    $strSql  .= "".$postcode.", \n";
    $strSql  .= "'".$prefecture_name."', \n";
    $strSql  .= "'".$city_name."', \n";
    $strSql  .= "'".$town_name."', \n";
    $strSql  .= "'".$prefecture_kana."', \n";
    $strSql  .= "'".$city_kana."', \n";
    $strSql  .= "'".$town_kana."' \n";
    $strSql  .= ") \n";
    return $this->query($strSql);
  }

  function select_m_city($prefecture_name,$city_name){
    $strSql   = "select * from m_city where prefecture_name = '".$prefecture_name."' and city_name like '%".$city_name."%' \n";
    return $this->query($strSql);
  }

  function count_member_city_code($city_code){
    $strSql  = "select count(*) as count from member_city where city_code = ".$city_code." \n";
    return $this->query($strSql);
  }

  function select_city_name_for_fuda(){
    $strSql   = "select * from m_city limit 1900 \n";
    return $this->query($strSql);
  }
}