<?php
class SalesHistory extends AppModel
{
public $useTable = 'member_position';

  function insert_sales_hisotry($member_code,$member_name,$town_member_code,$town_member_name,$max_point,$sales_count,$main_product_code){
    $strSql   = "insert into sales_history( \n";
    $strSql  .= "member_code, \n";
    $strSql  .= "member_name, \n";
    $strSql  .= "main_product_code, \n";
    $strSql  .= "town_member_code, \n";
    $strSql  .= "town_member_name, \n";
    $strSql  .= "max_point, \n";
    $strSql  .= "sales_count, \n";
    $strSql  .= "last_visited_date \n";
    $strSql  .= ")values( \n";
    $strSql  .= "".$member_code.", \n";
    $strSql  .= "'".$member_name."', \n";
    $strSql  .= "".$main_product_code.", \n";
    $strSql  .= "".$town_member_code.", \n";
    $strSql  .= "'".$town_member_name."', \n";
    $strSql  .= "".$max_point.", \n";
    $strSql  .= "".$sales_count.", \n";
    $strSql  .= "now()  \n";
    $strSql  .= ") \n";
    return $this->query($strSql);
  }

  function select_sales_history_detail($sales_history_code){
    $strSql   = "select * from sales_history where sales_history_code = ".$sales_history_code."  \n";
    return $this->query($strSql);
  }

  function select_sales_history($member_code){
    $strSql   = "select * from sales_history where member_code = ".$member_code." order by last_visited_date desc  \n";
    return $this->query($strSql);
  }

  function select_member_town_valuation($member_code,$member_town_code){
    $strSql   = "select   \n";
    $strSql  .= " *  \n";
    $strSql  .= "from  \n";
    $strSql  .= "member_town_valuation,members  \n";
    $strSql  .= "where   \n";
    $strSql  .= "member_town_valuation.member_town_code = members.member_code and  \n";
    $strSql  .= "member_town_valuation.member_code = ".$member_code." and   \n";
    $strSql  .= "member_town_valuation.member_town_code = ".$member_town_code."   \n";
    $strSql  .= "order by   \n";
    $strSql  .= "member_town_valuation_code desc,member_town_valuation.decision_date desc limit 8  \n";
    return $this->query($strSql);
  }

  function select_member_town_valuation_top($member_code){
    $strSql   = "select   \n";
    $strSql  .= " *  \n";
    $strSql  .= "from  \n";
    $strSql  .= "member_town_valuation,members  \n";
    $strSql  .= "where   \n";
    $strSql  .= "member_town_valuation.member_town_code = members.member_code and  \n";
    $strSql  .= "member_town_valuation.member_code = ".$member_code."  \n";
    $strSql  .= "order by   \n";
    $strSql  .= "member_town_valuation_code desc,member_town_valuation.decision_date desc limit 2  \n";
    return $this->query($strSql);
  }

  function update_hyoka_flag($sales_history_code){
    $strSql = "update sales_history set hyoka_flag = 1 where sales_history_code =  ".$sales_history_code."  \n";
    return $this->query($strSql);
  }

  function select_todays_town_visited_list($town_member_code){
    $strSql   = "select  \n";
    $strSql  .= "*  \n";
    $strSql  .= "from  \n";
    $strSql  .= "sales_history,members  \n";
    $strSql  .= "where  \n";
    $strSql  .= " sales_history.member_code = members.member_code and \n";
    $strSql  .= " sales_history.town_member_code = ".$town_member_code."  \n";
    $strSql  .= "order by  \n";
    $strSql  .= " sales_history.last_visited_date desc limit 12 \n";
    return $this->query($strSql);
  }

  function select_todays_town_visited_detail($member_code,$town_member_code){
    $strSql   = "select  \n";
    $strSql  .= "*  \n";
    $strSql  .= "from  \n";
    $strSql  .= "sales_history,members  \n";
    $strSql  .= "where  \n";
    $strSql  .= " sales_history.member_code = members.member_code and \n";
    $strSql  .= " sales_history.member_code = ".$member_code." and  \n";
    $strSql  .= " sales_history.town_member_code = ".$town_member_code."  \n";
    $strSql  .= "order by  \n";
    $strSql  .= " sales_history.last_visited_date desc \n";
    return $this->query($strSql);
  }

  function member_buy_list($member_code){
    $strSql   = "select * from sales_history where sales_member_code = ".$member_code." order by last_visited_date desc  \n";
    return $this->query($strSql);
  }

  function member_sales_list($member_code){
    $strSql   = "select  \n";
    $strSql  .= "*  \n";
    $strSql  .= "from   \n";
    $strSql  .= "sales_history,members   \n";
    $strSql  .= "where   \n";
    $strSql  .= "sales_history.town_member_code =members.member_code and  \n";
    $strSql  .= "sales_history.member_code = ".$member_code."   \n";
    $strSql  .= "order by   \n";
    $strSql  .= "sales_history.last_visited_date desc  \n";
    return $this->query($strSql);
  }

  function member_sales_list_limit_2($member_code){
    $strSql   = "select  \n";
    $strSql  .= "*  \n";
    $strSql  .= "from   \n";
    $strSql  .= "sales_history,members   \n";
    $strSql  .= "where   \n";
    $strSql  .= "sales_history.town_member_code =members.member_code and  \n";
    $strSql  .= "sales_history.member_code = ".$member_code."   \n";
    $strSql  .= "order by   \n";
    $strSql  .= "sales_history.last_visited_date desc  \n";
    $strSql  .= "limit 1   \n";
    return $this->query($strSql);
  }

  function select_count_sales_history($member_code,$town_member_code){
    $strSql   = "select count(*) as count from sales_history where member_code = ".$member_code." and town_member_code = ".$town_member_code."  \n";
    return $this->query($strSql);
  }

  function update_sales_history_main_product_code($member_code,$main_product_code){
    $strSql   = "update sales_history set main_product_code = ".$main_product_code." where member_code =  ".$member_code."  \n";
    return $this->query($strSql);
  }

  function update_sales_history($member_code,$town_member_code){
    $strSql   = "update sales_history set last_visited_date = now() where member_code =  ".$member_code." and town_member_code = ".$town_member_code."  \n";
    return $this->query($strSql);
  }
}
