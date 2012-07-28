<?php
class MemberMaterial extends AppModel
{
public $useTable = 'member_position';

  function insert_member_material($material_code,$member_code){
    $strSql = "insert into member_material (material_code,member_code,insert_date) values ( \n";
    $strSql .= "".$material_code.",".$member_code.",now()) \n";
    return $this->query($strSql);
  }

  function select_my_materials($member_code,$genre_code){
    $strSql  = "select * from material,member_material where  \n";
    $strSql .= "material.material_code = member_material.material_code \n";
    $strSql .= "and material.genre_code = ".$genre_code."  \n";
    $strSql .= "and member_material.member_code = ".$member_code." and used_flag <> 1 \n";
    return $this->query($strSql);
  }

  function update_member_material_used_flag($member_material_code){
    $strSql = "update member_material set used_flag = 1 where member_material_code = ".$member_material_code." \n";
    return $this->query($strSql);
  }

}