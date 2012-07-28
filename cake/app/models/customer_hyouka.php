<?php
class CustomerHyouka extends AppModel
{
public $useTable = 'member_position';
  function select_customer_hyouka($member_code){
    $strSql   = "select * from customer_hyouka where member_code = ".$member_code." order by decision_date desc limit 5 \n";
    return $this->query($strSql);
  }
}