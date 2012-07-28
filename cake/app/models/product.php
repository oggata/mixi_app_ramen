<?php
class Product extends AppModel
{
public $useTable = 'member_position';

  function insert_into_m_postcode($postcode,$prefecture_name,$city_name,$town_name,$prefecture_kana,$city_kana,$town_kana){
    $strSql  = "insert into m_postcode( \n";
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

  function insert_member_city($member_code,$city_code,$prefecture_code,$prefecture_name,$city_name){
    $strSql   = "insert into member_city( \n";
    $strSql  .= "member_code, \n";
    $strSql  .= "city_code, \n";
    $strSql  .= "prefecture_code, \n";
    $strSql  .= "prefecture_name, \n";
    $strSql  .= "city_name, \n";
    $strSql  .= "add_time \n";
    $strSql  .= ")values( \n";
    $strSql  .= "".$member_code.", \n";
    $strSql  .= "".$city_code.", \n";
    $strSql  .= "".$prefecture_code.", \n";
    $strSql  .= "'".$prefecture_name."', \n";
    $strSql  .= "'".$city_name."', \n";
    $strSql  .= "now() \n";
    $strSql  .= ") \n";
    return $this->query($strSql);
  }

  function select_count_product_member($member_code){
    $strSql   = "select count(*) as count from product where member_code = ".$member_code." and delete_flag = 0 order by product_code desc \n";
    return $this->query($strSql);
  }

  function insert_default_product($member_code){
    $strSql  = " insert into product (	\n";
    $strSql .= " member_code,	\n";
    $strSql .= " product_name,	\n";
    $strSql .= " c_1_code,c_1_id,c_1_name,	\n";
    $strSql .= " c_2_code,c_2_id,c_2_name,	\n";
    $strSql .= " c_3_code,c_3_id,c_3_name,	\n";
    $strSql .= " c_4_code,c_4_id,c_4_name,	\n";
    $strSql .= " c_5_code,c_5_id,c_5_name,	\n";
    $strSql .= " c_6_code,c_6_id,c_6_name,	\n";
    $strSql .= " c_7_code,c_7_id,c_7_name,	\n";
    $strSql .= " c_8_code,c_8_id,c_8_name,	\n";
    $strSql .= " c_9_code,c_9_id,c_9_name,	\n";
    $strSql .= " c_10_code,c_10_id,c_10_name,	\n";
    $strSql .= " gu_kosu,	\n";
    $strSql .= " product_price,	\n";
    $strSql .= " product_kotteri_point,	\n";
    $strSql .= " product_volume_point,	\n";
    $strSql .= " delete_flag	\n";
    $strSql .= " )values(	\n";
    $strSql .= "".$member_code.",	\n";
    $strSql .= " null,	\n";
    $strSql .= " 3,'sara_3','皿（白)',	\n";
    $strSql .= " 6,'tonkotsu_1','豚骨',	\n";
    $strSql .= " 11,'hoso_s','細ストレート',	\n";
    $strSql .= " 141,'chasyu_6','チャーシュー',	\n";
    $strSql .= " 35,'menma_1','メンマ',	\n";
    $strSql .= " 111,'benisyoga_3','紅しょうが',	\n";
    $strSql .= " 0,null,null,	\n";
    $strSql .= " 0,null,null,	\n";
    $strSql .= " 0,null,null,	\n";
    $strSql .= " 0,null,null,	\n";
    $strSql .= " 3,	\n";
    $strSql .= " 630,	\n";
    $strSql .= " 3,	\n";
    $strSql .= " 3,	\n";
    $strSql .= " 0	\n";
    $strSql .= " );	\n";
    return $this->query($strSql);
  }

  function select_null_product_count($member_code){
    $strSql = "select count(*) as count from product where member_code = ".$member_code." and c_1_code = 0 \n";
    return $this->query($strSql);
  }

  function select_product_list_member($member_code,$page_start_no,$page_end_no){
    $strSql   = "select * from product where member_code = ".$member_code." and delete_flag = 0 order by product_code desc \n";
    $strSql .= " limit ".$page_start_no.",".$page_end_no."	\n";
    return $this->query($strSql);
  }

  function select_product_detail($product_code){
    $strSql   = "select * from product where product_code = ".$product_code." \n";
    return $this->query($strSql);
  }

  function update_product_delete_flag($product_code){
    $strSql   = "update product set delete_flag = 1 where product_code = ".$product_code." \n";
    return $this->query($strSql);
  }

  function update_product_detail($product_code,$colum_id,$material_code,$column_name,$material_name,$colum_id_name,$material_id){
    $strSql   = "update product set ".$colum_id." = ".$material_code.",".$column_name." = '".$material_name."' ,".$colum_id_name." = '".$material_id."' where product_code = ".$product_code." \n";
    return $this->query($strSql);
  }

  function insert_prodcut($member_code){
    $strSql = "insert into product (member_code)values(".$member_code.") \n";
    return $this->query($strSql);
  }

  function select_last_product_code(){
    $strSql   = "select last_insert_id() as last_id  from product  \n";
    return $this->query($strSql);
  }

  function select_autoincrement_product_code(){
    $strSql   = "select LAST_INSERT_ID() as id_num	\n";
    return $this->query($strSql);
  }

  function update_product_contents($product_code,$target_code,$c_code,$c_id,$c_name){
    $c_code_column = 'c_'.$target_code.'_code';
    $c_id_column = 'c_'.$target_code.'_id';
    $c_name_column =  'c_'.$target_code.'_name';
    $strSql   = "update product set	\n";
    $strSql   .= "".$c_code_column." = ".$c_code.",	\n";
    $strSql   .= "".$c_id_column." = '".$c_id."',	\n";
    $strSql   .= "".$c_name_column." = '".$c_name."'	\n";
    $strSql   .= "where	\n";
    $strSql   .= "	product_code = ".$product_code." 	\n";
    return $this->query($strSql);
  }
}