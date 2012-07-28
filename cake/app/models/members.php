<?php
class Members extends AppModel
{
public $useTable = 'member_position';

  function select_member_ranking_count($member_code){
    $strSql    = "select  \n";
    $strSql   .= "count(*) + 1 as count  \n";
    $strSql   .= "from  \n";
    $strSql   .= "members  \n";
    $strSql   .= "where  \n";
    $strSql   .= "sales_product_count > ( \n";
    $strSql   .= "select  \n";
    $strSql   .= "sales_product_count  \n";
    $strSql   .= "from  \n";
    $strSql   .= "members  \n";
    $strSql   .= "where  \n";
    $strSql   .= "member_code = ".$member_code." \n";
    $strSql   .= ") \n";
    return $this->query($strSql);
  }

  function select_all_member_count(){
    $strSql = "select count(*) as count from members  \n";
    return $this->query($strSql);
  }

  function login_check($mixi_account_code){
    $strSql   = "select \n";
    $strSql   .= "count(*) as count \n";
    $strSql   .= "from members where mixi_account_id = '".$mixi_account_code."' \n";
    return $this->query($strSql);
  }

  function update_mixi_login_name($mixi_account_id,$mixi_name,$mixi_thumbnail){
    $strSql    = "update members set \n";
    $strSql   .= "member_name = '".$mixi_name."',thumnail_url = '".$mixi_thumbnail."',mixi_account_id = '".$mixi_account_id."' \n";
    $strSql   .= "where mixi_account_id = ".$mixi_account_id." \n";
    return $this->query($strSql);
  }

  function get_login_data_mixi($mixi_account_code){
    $strSql    = "select \n";
    $strSql   .= "* \n";
    $strSql   .= "from members where mixi_account_id = '".$mixi_account_code."' \n";
    return $this->query($strSql);
  }

  function select_member_detail($member_code){
    $strSql    = "select \n";
    $strSql   .= "* \n";
    $strSql   .= "from members where member_code = ".$member_code." \n";
    return $this->query($strSql);
  }

  function update_member_xi_number($member_code,$moved_masu_place_code,$xi_count){
    $strSql   = "update members set target_code = ".$moved_masu_place_code.",last_xi_count = ".$xi_count.",last_xi_update_date = now() where member_code = ".$member_code." \n";
    return $this->query($strSql);
  }

  function update_money($after_price,$member_code){
    $strSql   = "update members set money = ".$after_price.",last_xi_update_date = now() where member_code = ".$member_code." \n";
    return $this->query($strSql);
  }

  function update_main_product($member_code,$product_code){
    $strSql  = "update members set main_product_code = ".$product_code." where member_code = ".$member_code." \n";
    return $this->query($strSql);
  }

  function update_member_map_code($member_code,$map_code,$item_position_type_code){
    $strSql  = "update members set map_code = ".$map_code.",item_position_type_code = ".$item_position_type_code." where member_code = ".$member_code." \n";
    return $this->query($strSql);
  }

  function select_m_lv_exp($lv){
    $strSql   = "select * from m_lv_exp where lv = ".$lv." \n";
    return $this->query($strSql);
  }

  function insert_members($mixi_account_id,$member_name,$thumbnail_url,$town_code){
    $strSql    = "insert into members( \n";
    $strSql   .= "mixi_account_code, \n";
    $strSql   .= "mixi_account_id, \n";
    $strSql   .= "member_name, \n";
    $strSql   .= "money, \n";
    $strSql   .= "map_code, \n";
    $strSql   .= "target_code, \n";
    $strSql   .= "target_id, \n";
    $strSql   .= "sales_product_count, \n";
    $strSql   .= "product_quority, \n";
    $strSql   .= "last_update_date, \n";
    $strSql   .= "last_xi_count, \n";
    $strSql   .= "lv, \n";
    $strSql   .= "exp, \n";
    $strSql   .= "sum_exp, \n";
    $strSql   .= "least_next_exp, \n";
    $strSql   .= "main_product_code, \n";
    $strSql   .= "todays_sales_product_count, \n";
    $strSql   .= "lv_comment, \n";
    $strSql   .= "thumnail_url, \n";
    $strSql   .= "item_position_type_code \n";
    $strSql   .= ")values( \n";
    $strSql   .= "0, \n";
    $strSql   .= "'".$mixi_account_id."', \n";
    $strSql   .= "'".$member_name."', \n";
    $strSql   .= "500, \n";
    $strSql   .= "".$town_code.", \n";
    $strSql   .= "45, \n";
    $strSql   .= "'', \n";
    $strSql   .= "0, \n";
    $strSql   .= "0, \n";
    $strSql   .= "now(), \n";
    $strSql   .= "1, \n";
    $strSql   .= "1, \n";
    $strSql   .= "0, \n";
    $strSql   .= "0, \n";
    $strSql   .= "1000, \n";
    $strSql   .= "0, \n";
    $strSql   .= "0, \n";
    $strSql   .= "'Lv1.初心者', \n";
    $strSql   .= "'".$thumbnail_url."', \n";
    $strSql   .= "1 \n";
    $strSql   .= "); \n";
    return $this->query($strSql);
  }

  function select_member_ranking(){
    $strSql   = "select * from members order by sales_product_count desc,todays_sales_product_count desc limit 50 \n";
    return $this->query($strSql);
  }

  function select_autoincrement_member_code(){
    $strSql   = "select LAST_INSERT_ID() as id_num	\n";
    return $this->query($strSql);
  }

  function select_member_town_valuation_latest($member_code,$last_update_date){
    $strSql    = "select  \n";
    $strSql   .= "*  \n";
    $strSql   .= "from  \n";
    $strSql   .= "member_town_valuation,members \n";
    $strSql   .= "where  \n";
    $strSql   .= "member_town_valuation.member_town_code = members.member_code and \n";
    $strSql   .= "member_town_valuation.member_code = ".$member_code." and  \n";
    $strSql   .= "member_town_valuation.decision_date > '".$last_update_date."' and \n";
    $strSql   .= "member_town_valuation.read_flag = 0  \n";
    $strSql   .= "order by member_town_valuation.decision_date desc limit 1 \n";
    return $this->query($strSql);
  }

  function update_member_town_valuation_after_read($member_code){
    $strSql   = "update member_town_valuation set read_flag = 1 where member_code = ".$member_code." and read_flag = 0  \n";
    return $this->query($strSql);
  }

  function select_member_town_taste_rand_one(){
    $strSql   = "select * from member_town_taste order by rand() limit 1  \n";
    return $this->query($strSql);
  }

  function update_member_jump_map_count($member_code,$jump_map_count){
    $strSql   = "update members set jump_map_count = ".$jump_map_count." where member_code = ".$member_code."  \n";
    return $this->query($strSql);
  }
}