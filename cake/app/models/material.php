<?php
class Material extends AppModel
{
public $useTable = 'member_position';

  function select_parent_material_list_by_genre($genre_code){
    $strSql    = "select \n";
    $strSql   .= "parent_material.parent_material_code, \n";
    $strSql   .= "parent_material.parent_material_name, \n";
    $strSql   .= "parent_material.parent_material_id, \n";
    $strSql   .= "sum(material.lv)/count(*) as per_lv \n";
    $strSql   .= "from \n";
    $strSql   .= "parent_material,material \n";
    $strSql   .= "where \n";
    $strSql   .= "parent_material.parent_material_code = material.parent_material_code and \n";
    $strSql   .= "parent_material.genre_code = ".$genre_code." \n";
    $strSql   .= "group by  \n";
    $strSql   .= "parent_material.parent_material_code, \n";
    $strSql   .= "parent_material.parent_material_name, \n";
    $strSql   .= "parent_material.parent_material_id \n";
    $strSql   .= "order by sum(material.lv)/count(*) \n";
    return $this->query($strSql);
  }

  function select_parent_material_list_by_town(){
    $strSql    = "select  \n";
    $strSql   .= "parent_material.parent_material_code,  \n";
    $strSql   .= "parent_material.parent_material_name,  \n";
    $strSql   .= "parent_material.parent_material_id,  \n";
    $strSql   .= "sum(material.lv)/count(*) as per_lv  \n";
    $strSql   .= "from  \n";
    $strSql   .= "parent_material,material  \n";
    $strSql   .= "where  \n";
    $strSql   .= "parent_material.parent_material_code = material.parent_material_code and  \n";
    $strSql   .= "parent_material.genre_code in (5,6,7,8)  \n";
    $strSql   .= "group by  \n";
    $strSql   .= "parent_material.parent_material_code,  \n";
    $strSql   .= "parent_material.parent_material_name,  \n";
    $strSql   .= "parent_material.parent_material_id  \n";
    $strSql   .= "order by sum(material.lv)/count(*)  \n";
    return $this->query($strSql);
  }

  function select_parent_material_lists(){
    $strSql    = "select  \n";
    $strSql   .= "parent_material.parent_material_code,  \n";
    $strSql   .= "parent_material.parent_material_name,  \n";
    $strSql   .= "parent_material.parent_material_id,  \n";
    $strSql   .= "sum(material.lv)/count(*) as per_lv  \n";
    $strSql   .= "from  \n";
    $strSql   .= "parent_material,material  \n";
    $strSql   .= "where  \n";
    $strSql   .= "parent_material.parent_material_code = material.parent_material_code and  \n";
    $strSql   .= "parent_material.genre_code in (5,6,7,8)  \n";
    $strSql   .= "group by  \n";
    $strSql   .= "parent_material.parent_material_code,  \n";
    $strSql   .= "parent_material.parent_material_name,  \n";
    $strSql   .= "parent_material.parent_material_id  \n";
    $strSql   .= "order by sum(material.lv)/count(*)  \n";
    return $this->query($strSql);
  }

  function select_material_count($genre_code){
    $strSql   = "select count(*) as count from material where parent_genre_code = ".$genre_code." \n";
    return $this->query($strSql);
  }

  function select_material_list_by_genre($genre_code){
    $strSql  = "select * from material where parent_material_code = ".$genre_code." \n";
    return $this->query($strSql);
  }

  function select_parent_material_list($genre_code){
    $strSql  = "select * from parent_material where genre_code = ".$genre_code." \n";
    return $this->query($strSql);
  }

  function select_material_detail($material_code){
    $strSql   = "select * from material where material_code = ".$material_code." \n";
    return $this->query($strSql);
  }

  function select_parent_material_detail($parent_material_code){
    $strSql  = "select * from parent_material where parent_material_code = ".$parent_material_code." \n";
    return $this->query($strSql);
  }
}