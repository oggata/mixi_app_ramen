<?php
class MapPosition extends AppModel
{
public $useTable = 'members';

  function select_map_position($map_code){
    $strSql   = "select * from map_position where map_code = ".$map_code." \n";
    return $this->query($strSql);
  }

  function select_map_detail($map_position_code){
    $strSql   = "select * from map_position where map_position_code = ".$map_position_code." \n";
    return $this->query($strSql);
  }

  function select_map_detail_by_position_code($position_code,$map_code){
    $strSql   = "select * from map_position where position_code = ".$position_code." and map_code = ".$map_code." \n";
    return $this->query($strSql);
  }

  function select_m_event_rand($genre_code){
    $strSql   = "select * from m_event where genre_code = ".$genre_code." order by rand() limit 1 \n";
    return $this->query($strSql);
  }

  function select_map_position_map_randam(){
    $strSql   = "select map_code from map_position order by rand() limit 1 \n";
    return $this->query($strSql);
  }
}

?>