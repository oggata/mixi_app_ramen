<?php
class MPrefectureTaste extends AppModel
{
public $useTable = 'member_position';

  function select_m_map_type(){
    $strSql   = "select * from m_map_type \n";
    return $this->query($strSql);
  }

  function select_m_map_type_detail($map_type_code){
    $strSql   = "select * from m_map_type where map_type_code = ".$map_type_code." \n";
    return $this->query($strSql);
  }

  function select_prefecture_tasete($prefecture_code){
    $strSql   = "select \n";
    $strSql  .= "*  \n";
    $strSql  .= "from  \n";
    $strSql  .= "member_town_taste,members,m_map_type  \n";
    $strSql  .= "where \n";
    $strSql  .= "member_town_taste.map_type_code = m_map_type.map_type_code and \n";
    $strSql  .= "member_town_taste.member_code = members.member_code and  \n";
    $strSql  .= "member_town_taste.member_code = ".$prefecture_code." \n";
    return $this->query($strSql);
  }

  function select_prefecture_tasete_randam_one($member_code){
    $strSql   = "select \n";
    $strSql  .= "* \n";
    $strSql  .= "from \n";
    $strSql  .= "member_town_taste,members \n";
    $strSql  .= "where \n";
    $strSql  .= "member_town_taste.member_code = members.member_code and \n";
    $strSql  .= "member_town_taste.member_code <> ".$member_code." \n";
    $strSql  .= "order by rand() limit 1 \n";
    return $this->query($strSql);
  }

  function insert_member_town_taste($data){
    $member_code = $data['member_code'];
    $member_name = $data['member_name'];
    $goal_men_type_code = $data['goal_men_type_code'];
    $goal_men_type_name = $data['goal_men_type_name'];
    $goal_soup_type_code = $data['goal_soup_type_code'];
    $goal_soup_type_name = $data['goal_soup_type_name'];
    $goal_product_price = $data['goal_product_price'];
    $goal_kotteri_point = $data['goal_kotteri_point'];
    $goal_volume_point = $data['goal_volume_point'];
    $hissu_material_code1 = $data['hissu_material_code1'];
    $hissu_material_name1 = $data['hissu_material_name1'];
    $hissu_material_code2 = $data['hissu_material_code2'];
    $hissu_material_name2 = $data['hissu_material_name2'];
    $hissu_material_code3 = $data['hissu_material_code3'];
    $hissu_material_name3 = $data['hissu_material_name3'];
    $map_type_code = $data['map_type_code'];
    $strSql   = "insert into member_town_taste ( \n";
    $strSql  .= "member_code, \n";
    $strSql  .= "member_name, \n";
    $strSql  .= "goal_men_type_code, \n";
    $strSql  .= "goal_men_type_name, \n";
    $strSql  .= "goal_soup_type_code, \n";
    $strSql  .= "goal_soup_type_name, \n";
    $strSql  .= "goal_product_price, \n";
    $strSql  .= "goal_kotteri_point, \n";
    $strSql  .= "goal_volume_point, \n";
    $strSql  .= "hissu_material_code1, \n";
    $strSql  .= "hissu_material_name1, \n";
    $strSql  .= "hissu_material_code2, \n";
    $strSql  .= "hissu_material_name2, \n";
    $strSql  .= "hissu_material_code3, \n";
    $strSql  .= "hissu_material_name3, \n";
    $strSql  .= "map_type_code \n";
    $strSql  .= ") values( \n";
    $strSql  .= "".$member_code.", \n";
    $strSql  .= "'".$member_name."', \n";
    $strSql  .= "".$goal_men_type_code.", \n";
    $strSql  .= "'".$goal_men_type_name."', \n";
    $strSql  .= "".$goal_soup_type_code.", \n";
    $strSql  .= "'".$goal_soup_type_name."', \n";
    $strSql  .= "".$goal_product_price.", \n";
    $strSql  .= "".$goal_kotteri_point.", \n";
    $strSql  .= "".$goal_volume_point.", \n";
    $strSql  .= "".$hissu_material_code1.", \n";
    $strSql  .= "'".$hissu_material_name1."', \n";
    $strSql  .= "".$hissu_material_code2.", \n";
    $strSql  .= "'".$hissu_material_name2."', \n";
    $strSql  .= "".$hissu_material_code3.", \n";
    $strSql  .= "'".$hissu_material_name3."', \n";
    $strSql  .= "".$map_type_code." \n";
    $strSql  .= ") \n";
    return $this->query($strSql);
  }


  function select_count_member_taste($member_code){
    $strSql   = "select count(*) as count from member_town_taste where member_code = ".$member_code." \n";
    return $this->query($strSql);
  }

  function select_member_taste($member_code){
    $strSql    = "select  \n";
    $strSql   .= "*  \n";
    $strSql   .= "from  \n";
    $strSql   .= "member_town_taste,m_prefecture, \n";
    $strSql   .= "members  \n";
    $strSql   .= "where  \n";
    $strSql   .= "member_town_taste.member_code = members.member_code and \n";
    $strSql   .= "m_prefecture.prefecture_code = member_town_taste.map_type_code and \n";
    $strSql   .= "members.member_code = ".$member_code." \n";
    return $this->query($strSql);
  }

  function delete_member_town_tasete($member_code){
    $strSql   = "delete from member_town_taste where member_code = ".$member_code." \n";
    return $this->query($strSql);
  }
}