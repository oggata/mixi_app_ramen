<?php
class RankingController extends AppController{
  var $uses = array('Members','Product');
  var $comment = array();
  var $components = array('Pager');

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    $data = $this->Members->select_member_ranking();
    $this->set('data',$data);
  }

  function member_detail(){
    $this->session_manage();
    $member_code = $this->params['named']['member_code'];
    if(strlen($member_code)==0){
      //セッションから会員番号を取得
      $member_code = $this->session_data['member_code'];
    }
    //ランキングを取得する
    $rank_data = $this->Members->select_member_ranking_count($member_code);
    $all_rank = $this->Members->select_all_member_count($member_code);
    $this->set('rank_txt',$rank_data[0][0]['count'].'/'.$all_rank[0][0]['count']);

    //所持しているレシピの数を数える
    $product_count_data = $this->Product->select_count_product_member($member_code);
    $recipi_count = $product_count_data[0][0]['count'];

    //詳細データを表示
    $data = $this->Members->select_member_detail($member_code);
    $member_name = $data[0]['members']['member_name'];
    $money = $data[0]['members']['money'];
    $thumnail_url = $data[0]['members']['thumnail_url'];
    $lv_comment = $data[0]['members']['lv_comment'];
    $sales_product_count = $data[0]['members']['sales_product_count'];
    $todays_sales_product_count = $data[0]['members']['todays_sales_product_count'];
    $main_product_code = $data[0]['members']['main_product_code'];
    $sum_exp = $data[0]['members']['sum_exp'];
    $least_next_exp = $data[0]['members']['least_next_exp'];
    $visited_town_count = $data[0]['members']['jump_map_count'];
    $this->set('member_code',$member_code);
    $this->set('member_name',$member_name);
    $this->set('money',$money);
    $this->set('thumnail_url',$thumnail_url);
    $this->set('lv_comment',$lv_comment);
    $this->set('sales_product_count',$sales_product_count);
    $this->set('todays_sales_product_count',$todays_sales_product_count);
    $this->set('recipi_count',$recipi_count);
    $this->set('main_product_code',$main_product_code);
    $this->set('sum_exp',$sum_exp);
    $this->set('least_next_exp',$least_next_exp);
    $this->set('visited_town_count',$visited_town_count);
    //ページ
    $page_no = $this->params['named']['page_no'];
    if(strlen($page_no)==0){
      $page_no = 1;
    }
    //全部の件数を調べる
    $c_data = $this->Product->select_count_product_member($member_code);
    $count_num = $c_data[0][0]['count'];
    $divide_no = 9;
    //ページ表示部分
    $vlist = $this->Pager->pagelink($divide_no,$count_num,'/cake/tyouri/product_list/page_no:',$page_no);
    $this->set('vlist',$vlist);
    $page_end_no = $divide_no * $page_no;
    $page_start_no = $page_end_no - ($divide_no - 1) -1;
    $data = $this->Product->select_product_list_member($member_code,$page_start_no,$page_end_no);
    $time = time();
    $this->set('time_txt',$time);
    $this->set('data',$data);
  }

  function place(){
  }

  function session_manage(){
    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['member_code'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}