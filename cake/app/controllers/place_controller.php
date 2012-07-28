<?php

class PlaceController extends AppController{

  var $uses = array('MPrefecture');
  var $comment = array();
  var $components = array('Pager');

  function get_gps(){
  }

  function top(){
  }

  function place_execute($coordinates){
    //経度と緯度を分ける
    $elements = split(",",$coordinates);
    $lat = $elements[0];
    $lon = $elements[1];

    //ＹａｈｏｏＡＰＩを使用
    $url = ReverseGeoCoder.'?lat='.$lat."&lon=".$lon."&appid=".YahooAppID;
    $xml = simplexml_load_file($url);

    //緯度、経度から都道府県、都市名を取得
    $prefecture_name = $xml->Feature->Property->AddressElement[0]->Name;
    $city_name = $xml->Feature->Property->AddressElement[1]->Name;

    //名前からマスター内を捜索
    $city_data = $this->MPrefecture->select_m_city($prefecture_name,$city_name);
    $m_city_count = count($city_data);

    //自分が取得済のものがあるか確認
    $count_data = $this->MPrefecture->count_member_city_code($city_data[0]['m_city']['city_code']);
    $city_count = $count_data[0][0]['count'];

    //そもそもマスターになければエラーになる
    if($m_city_count == 0){
      $message_txt = 'この土地は登録されていない為、千社札がありません。別の場所でお試し下さい';
      $fuda_no = 'default';
    }else{
      $message_txt = $prefecture_name.$city_name.'は既に取得済です';
      $fuda_no = $city_data[0]['m_city']['city_code'];
      //初回訪れた時だけカウント
      if($city_count == 0){
        $member_code = 1;
        $city_code = $city_data[0]['m_city']['city_code'];
        $prefecture_code = $city_data[0]['m_city']['prefecture_code'];
        $prefecture_name = $city_data[0]['m_city']['prefecture_name'];
        $city_name = $city_data[0]['m_city']['city_name'];
        $this->MPrefecture->insert_member_city($member_code,$city_code,$prefecture_code,$prefecture_name,$city_name);
        $message_txt = $prefecture_name.$city_name.'を取得しました！';
        $fuda_no = $city_code;
      }
    }
    $this->set('message_txt',$message_txt);
    $this->set('fuda_no',$fuda_no);
  }

  function city_list(){
    $member_code = 1;
    $prefecture_code = $this->params['named']['prefecture_code'];
    $page_no = $this->params['named']['page_no'];

    $m_city = $this->MPrefecture->select_prefecture_detail($prefecture_code);
    $city_count = $m_city[0]['m_prefecture']['city_count'];
    $prefecture_name = $m_city[0]['m_prefecture']['prefecture_name'];
    $this->set('prefecture_name',$prefecture_name);

    $divide_no = 25;
    $vlist = $this->Pager->pagelink($divide_no,$city_count,'/cake/place/city_list/prefecture_code:'.$prefecture_code.'/page_no:',$page_no);
    $this->set('vlist',$vlist);
    $page_end_no = $divide_no * $page_no;
    $page_start_no = $page_end_no - ($divide_no - 1) -1;

    //市町村の取得状態を取得する
    $data = $this->MPrefecture->select_city_list($prefecture_code,$member_code,$page_start_no,$page_end_no);
    $this->set('data',$data);
  }

  function place_list(){
    $member_code = 1;
    //都道府県の取得状態を取得する
    $data = $this->MPrefecture->select_get_prefecture_list($member_code);
    $this->set('data',$data);
  }
}