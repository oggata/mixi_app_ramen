<?php

class ShopController extends AppController{

  var $uses = array('Members','Material','MemberMaterial','MemberMessage');
  var $comment = array();
  var $components = array('Pager');

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    $genre_code = $this->params['named']['item_genre'];
    $page_no = $this->params['named']['page_no'];
    if(strlen($genre_code)==0){
      $genre_code = 7;
    }
    $data = $this->Material->select_parent_material_list_by_genre($genre_code);
    $this->set('data',$data);
  }

  function child_list($parent_genre_code){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    $data = $this->Material->select_material_list_by_genre($parent_genre_code);
    $this->set('data',$data);
    $mdata = $this->Members->select_member_detail($member_code);
    $money = $mdata[0]['members']['money'];
    $level = $mdata[0]['members']['lv'];
    $this->set('money',$money);
    $this->set('level',$level);
  }

  function buy_confirm(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    $material_code = $this->params['data']['submit'];
    $data = $this->Material->select_material_detail($material_code);
    $shiire_price = $data[0]['material']['shiire_price'];
    $this->set('data',$data);
    $this->set('material_code',$material_code);
    //購入前残高
    $m_data = $this->Members->select_member_detail($member_code);
    $before_price = $m_data['0']['members']['money'];
    $this->set('before_price',$before_price);
    //購入後残高
    $after_price = $before_price - $shiire_price;
    $this->set('after_price',$after_price);
  }

  function buy(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    $material_code = $this->params['data']['submit'];
    $data = $this->Material->select_material_detail($material_code);
    $this->set('data',$data);
    //購入金額をマイナスする処理
    $m_data = $this->Members->select_member_detail($member_code);
    $this->set('before_price',$m_data['0']['members']['money']);
    $after_price = $m_data['0']['members']['money'] - $data[0]['material']['price'];
    if($after_price < 0){
      $this->redirect('/mixi_shop/top/item_genre:1/page_no:1/');
    }
    //金額を調整
    $this->Members->update_money($after_price,$member_code);
    $product_name = $data[0]['material']['material_name'];
    //アイテムを入れる
    $this->MemberMaterial->insert_member_material($material_code,$member_code);
    $message_category = 2;
    $message_txt = $product_name.'を購入しました。';
    $this->MemberMessage->insert_member_message($member_code,$message_category,$message_txt);
  }

  function session_manage(){
    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['member_code'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}