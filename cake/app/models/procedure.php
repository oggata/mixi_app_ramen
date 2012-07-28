<?php
class Procedure extends AppModel
{
public $useTable = 'member_position';

  function call_money($member_code,$event_code){
    $strSql   = "call money(".$member_code.",".$event_code.") \n";
    return $this->query($strSql);
  }

  function call_exp($member_code,$event_code){
    $strSql   = "call get_exp(".$member_code.",".$event_code.") \n";
    return $this->query($strSql);
  }

  function call_product_manage($product_code){
    $strSql   = "call product_manage(".$product_code.") \n";
    return $this->query($strSql);
  }

  function call_sales_exe(){
    $strSql   = "call sales_exe() \n";
    return $this->query($strSql);
  }

  function call_customer($prefecture_code,$product_code){
    $strSql   = "call customer(".$prefecture_code.",".$product_code.") \n";
    return $this->query($strSql);
  }

  function call_exp_sales_member($yatai_member_code,$town_member_code,$exp,$star){
    $strSql   = "call get_exp_sales_member(".$yatai_member_code.",".$exp.") \n";
    return $this->query($strSql);
  }

  function daily_cal(){
    $strSql   = "call daily_cal() \n";
    return $this->query($strSql);
  }
}