<?php

class TyouriController extends AppController{

  var $uses = array('MPrefectureTaste','SalesHistory','Members','Product','MemberMaterial','Material','Procedure');
  var $comment = array();
  var $components = array('Pager');

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    //現在のメインを取得
    $data = $this->Members->select_member_detail($member_code);
    $main_product_code = $data[0]['members']['main_product_code'];
    //売上数を取得する
    $this->set('sales_product_count',$data[0]['members']['sales_product_count']);
    $this->set('todays_sales_product_count',$data[0]['members']['todays_sales_product_count']);
    //商品情報を取得する
    $p_data = $this->Product->select_product_detail($main_product_code);
    $product_price = $p_data[0]['product']['product_price'];
    $product_kotteri_point = $p_data[0]['product']['product_kotteri_point'];
    $product_volume_point = $p_data[0]['product']['product_volume_point'];
    $product_men_type_name = $p_data[0]['product']['product_men_type_name'];
    $product_soup_type_name = $p_data[0]['product']['product_soup_type_name'];
    $this->set('c_1_name',$p_data[0]['product']['c_1_name']);
    $this->set('c_2_name',$p_data[0]['product']['c_2_name']);
    $this->set('c_3_name',$p_data[0]['product']['c_3_name']);
    $this->set('product_price',$product_price);
    $this->set('product_kotteri_point',$product_kotteri_point);
    $this->set('product_volume_point',$product_volume_point);
    $this->set('product_men_type_name',$product_men_type_name);
    $this->set('product_soup_type_name',$product_soup_type_name);
    //今いる町の名前を取得する
    $map_code = $data[0]['members']['map_code'];
    $mtt = $this->MPrefectureTaste->select_prefecture_tasete($map_code);
    //訪れた町の名前
    $member_name = $mtt[0]['members']['member_name'];
    $map_type_name = $mtt[0]['m_map_type']['map_type_name'];
    $map_name =$member_name.$map_type_name;
    $this->set('map_name',$map_name);
    //町ごとの評判を取得する
    $hyouka = $this->SalesHistory->select_member_town_valuation($member_code,$map_code);
    $this->set('hyouka',$hyouka);
    $this->set('member_code',$member_code);
    $this->set('main_product_code',$main_product_code);
    $time = time();
    $this->set('now_time',$time);
  }

  function create_new_product(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];

    //空の皿数を計算
    $null_product_data = $this->Product->select_null_product_count($member_code);
    if($null_product_data[0][0]['count'] < 3){
      $this->Product->insert_prodcut($member_code);
      //デフォルトの画像をコピーする
      $data = $this->Product->select_last_product_code();
      $last_product_code = $data[0][0]['last_id'];
      $file = IMG_DIR.'/product_default.png';
      $newfile = TOP_IMG_DIR.'/top/'.$member_code.'/'.$last_product_code.'.png';
      if (!copy($file, $newfile)) {
          echo "failed to copy $file...\n";
      }
    }
    $this->redirect('/tyouri/product_list/');
  }

  function delete_product($product_code){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    $this->Product->update_product_delete_flag($product_code);
    $this->redirect('/tyouri/product_list/');
  }

  function product_list(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];

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

  function detail($product_code){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    $data = $this->Members->select_member_detail($member_code);
    $main_product_code = $data[0]['members']['main_product_code'];
    if ($product_code == $main_product_code){
      $this->set('on_sales_flag',1);
    }else{
      $this->set('on_sales_flag',0);
    }
    $data = $this->Product->select_product_detail($product_code);
    $error_txt = $this->Session->read('ErrorTxt');
    if(strlen($error_txt)>0){
      $this->set('error_txt',$error_txt);
    }else{
      $this->set('error_txt','');
    }
    $this->Session->write('ErrorTxt','');
    $this->Session->write('ProductCode',$product_code);
    $time=time();
    $this->set('product_code',$product_code);
    $this->set('product_path','/top_img/top/'.$member_code.'/'.$product_code.'.png?'.$time);
    $this->set('c_1_name',$data[0]['product']['c_1_name']);
    $this->set('c_2_name',$data[0]['product']['c_2_name']);
    $this->set('c_3_name',$data[0]['product']['c_3_name']);
    $this->set('c_4_name',$data[0]['product']['c_4_name']);
    $this->set('c_5_name',$data[0]['product']['c_5_name']);
    $this->set('c_6_name',$data[0]['product']['c_6_name']);
    $this->set('c_7_name',$data[0]['product']['c_7_name']);
    $this->set('c_8_name',$data[0]['product']['c_8_name']);
    $this->set('c_9_name',$data[0]['product']['c_9_name']);
    $this->set('c_10_name',$data[0]['product']['c_10_name']);

    $this->set('product_price',$data[0]['product']['product_price']);
    $this->set('product_kotteri_point',$data[0]['product']['product_kotteri_point']);
    $this->set('product_volume_point',$data[0]['product']['product_volume_point']);
  }

  function select_detail($category_code){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    $product_code = $this->Session->read('ProductCode');
    //商品情報を取得
    $data = $this->Product->select_product_detail($product_code);
    $this->set('product_price',$data[0]['product']['product_price']);
    $this->set('product_kotteri_point',$data[0]['product']['product_kotteri_point']);
    $this->set('product_volume_point',$data[0]['product']['product_volume_point']);
    $time=time();
    $this->set('product_code',$product_code);
    $this->set('product_path','/top_img/top/'.$member_code.'/'.$product_code.'.png?'.$time);
    if($category_code <> 1){
      //皿は必須
      $p_data = $this->Product->select_product_detail($product_code);
      $c_1_code = $p_data[0]['product']['c_1_code'];
      if($c_1_code == 0){
        $this->Session->write('ErrorTxt','皿がありません。先にお皿を選んでください。');
        $this->redirect('/tyouri/detail/'.$product_code);
      }
    }
    if($category_code == 3 or $category_code == 4 or $category_code == 5 or $category_code == 6 or $category_code == 7 or $category_code == 8 or $category_code == 9 or $category_code == 10){
      $c_2_code = $p_data[0]['product']['c_2_code'];
      if($c_2_code == 0){
        $this->Session->write('ErrorTxt','スープが入っていません。スープを先に選んでください。');
        $this->redirect('/tyouri/detail/'.$product_code);
      }
    }
    $search_category_code = $category_code;
    //具の選択の場合
    if ($search_category_code >= 4){
      $search_category_code = 4;
    }
    //背景の選択の場合
    if ($search_category_code == 10){
      $search_category_code = 5;
    }
    $data = $this->MemberMaterial->select_my_materials($member_code,$search_category_code);
    $member_material_code = $data[0]['material']['material_code'];
    $this->set('data',$data);
    if(strlen($product_code)==0){
      $this->redirect('/tyouri/product_list/');
    }
    $this->set('product_code',$product_code);
    $this->set('genre_code',$category_code);
    $this->set('material_code',$member_material_code);
  }

  function update_detail(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    $product_code = $this->params['named']['product_code'];
    $genre_code = $this->params['named']['genre_code'];
    $material_code = $this->params['named']['material_code'];
    $member_material_code = $this->params['named']['member_material_code'];
    $materials = $this->Material->select_material_detail($material_code);
    $material_name = $materials[0]['material']['material_name'];
    $material_id = $materials[0]['material']['material_id'];
    $colum_id = 'c_'.$genre_code.'_code';
    $colum_name = 'c_'.$genre_code.'_name';
    $colum_id_name = 'c_'.$genre_code.'_id';
    $this->Product->update_product_detail($product_code,$colum_id,$material_code,$colum_name,$material_name,$colum_id_name,$material_id);
    $this->MemberMaterial->update_member_material_used_flag($member_material_code);
    $this->refresh_product_img($product_code);
    $this->Procedure->call_product_manage($product_code);
    $this->redirect('/tyouri/detail/'.$product_code);
  }

  function change_layer(){
    $product_code = $this->params['named']['product_code'];
    $target_code = $this->params['named']['target_code'];
    $direction_code = $this->params['named']['direction_code'];
    $data = $this->Product->select_product_detail($product_code);
    for($i = 4;$i<=10;$i++){
      if($target_code == $i){
        if($direction_code == 1){
          $this->Product->update_product_contents($product_code,$i-1,$data[0]['product']['c_'.$i.'_code'],$data[0]['product']['c_'.$i.'_id'],$data[0]['product']['c_'.$i.'_name']);
          $this->Product->update_product_contents($product_code,$i,$data[0]['product']['c_'.($i-1).'_code'],$data[0]['product']['c_'.($i-1).'_id'],$data[0]['product']['c_'.($i-1).'_name']);
        }elseif($direction_code == 2){
          $this->Product->update_product_contents($product_code,($i+1),$data[0]['product']['c_'.$i.'_code'],$data[0]['product']['c_'.$i.'_id'],$data[0]['product']['c_'.$i.'_name']);
          $this->Product->update_product_contents($product_code,$i,$data[0]['product']['c_'.($i+1).'_code'],$data[0]['product']['c_'.($i+1).'_id'],$data[0]['product']['c_'.($i+1).'_name']);
        }
      }
    }
    $this->refresh_product_img($product_code);
    $this->redirect('/tyouri/detail/'.$product_code);
  }

  function delete_layer(){
    $product_code = $this->params['named']['product_code'];
    $target_code = $this->params['named']['target_code'];
    $this->Product->update_product_contents($product_code,$target_code,'0','','');
    $this->Procedure->call_product_manage($product_code);
    $this->refresh_product_img($product_code);
    $this->redirect('/tyouri/detail/'.$product_code);
  }

  function update_main_menu($product_code){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_code = $this->session_data['member_code'];
    //対象の商品が準備済か確認
    $data = $this->Product->select_product_detail($product_code);
    $c_1_code = $data[0]['product']['c_1_code'];
    $c_2_code = $data[0]['product']['c_2_code'];
    $c_3_code = $data[0]['product']['c_3_code'];
    if ($c_1_code == 0 or $c_2_code == 0 or $c_3_code == 0){
      $this->Session->write('ErrorTxt','この商品はまだ完成していません。少なくとも、皿・麺・スープを選んでください。');
      $this->redirect('/tyouri/detail/'.$product_code);
    }else{
      $this->Members->update_main_product($member_code,$product_code);
      $this->redirect('/tyouri/detail/'.$product_code);
    }
  }

  function refresh_product_img($product_code){
    $im = new Imagick(IMG_DIR."/material/ramen_base.png");
    $im->thumbnailImage(380, null);
    $canvas = new Imagick();
    $publish_x = 200;
    $publish_y = 200;
    $width = $im->getImageWidth() + 0;
    $height = $im->getImageHeight() + 0;
    $canvas->newImage($width, $height, new ImagickPixel('none'));
    $canvas->setCompressionQuality(5);
    $canvas->setImageFormat("png");
    $canvas->resizeImage($publish_x, $publish_y, imagick::FILTER_MITCHELL, 1, false);
    //商品詳細データの取得
    $p_data = $this->Product->select_product_detail($product_code);
    $member_code = $p_data[0]['product']['member_code'];
    $c_1_code = $p_data[0]['product']['c_1_code'];
    $c_1_id = $p_data[0]['product']['c_1_id'];
    if($c_1_code>0){
      $c_1 = new Imagick(IMG_DIR."/material/".$c_1_id.".png");
      $c_1->resizeImage($publish_x, $publish_y, imagick::FILTER_MITCHELL, 1, false);
      $canvas->compositeImage($c_1, imagick::COMPOSITE_OVER, 0, 0);
    }
    $c_3_code = $p_data[0]['product']['c_3_code'];
    $c_3_id = $p_data[0]['product']['c_3_id'];
    if($c_3_code>0){
      $c_3 = new Imagick(IMG_DIR."/material/".$c_3_id.".png");
      $c_3->resizeImage($publish_x, $publish_y, imagick::FILTER_MITCHELL, 1, false);
      $canvas->compositeImage($c_3, imagick::COMPOSITE_OVER, 0, 0);
    }
    $c_2_code = $p_data[0]['product']['c_2_code'];
    $c_2_id = $p_data[0]['product']['c_2_id'];
    if($c_2_code>0){
      $c_2 = new Imagick(IMG_DIR."/material/".$c_2_id.".png");
      $c_2->resizeImage($publish_x, $publish_y, imagick::FILTER_MITCHELL, 1, false);
      $canvas->compositeImage($c_2, imagick::COMPOSITE_OVER, 0, 0);
    }
    $c_4_code = $p_data[0]['product']['c_4_code'];
    $c_4_id = $p_data[0]['product']['c_4_id'];
    if($c_4_code>0){
      $c_4 = new Imagick(IMG_DIR."/material/".$c_4_id.".png");
      $c_4->resizeImage($publish_x, $publish_y, imagick::FILTER_MITCHELL, 1, false);
      $canvas->compositeImage($c_4, imagick::COMPOSITE_OVER, 0, 0);
    }
    $c_5_code = $p_data[0]['product']['c_5_code'];
    $c_5_id = $p_data[0]['product']['c_5_id'];
    if($c_5_code>0){
      $c_5 = new Imagick(IMG_DIR."/material/".$c_5_id.".png");
      $c_5->resizeImage($publish_x, $publish_y, imagick::FILTER_MITCHELL, 1, false);
      $canvas->compositeImage($c_5, imagick::COMPOSITE_OVER, 0, 0);
    }
    $c_6_code = $p_data[0]['product']['c_6_code'];
    $c_6_id = $p_data[0]['product']['c_6_id'];
    if($c_6_code>0){
      $c_6 = new Imagick(IMG_DIR."/material/".$c_6_id.".png");
      $c_6->resizeImage($publish_x, $publish_y, imagick::FILTER_MITCHELL, 1, false);
      $canvas->compositeImage($c_6, imagick::COMPOSITE_OVER, 0, 0);
    }
    $c_7_code = $p_data[0]['product']['c_7_code'];
    $c_7_id = $p_data[0]['product']['c_7_id'];
    if($c_7_code>0){
      $c_7 = new Imagick(IMG_DIR."/material/".$c_7_id.".png");
      $c_7->resizeImage($publish_x, $publish_y, imagick::FILTER_MITCHELL, 1, false);
      $canvas->compositeImage($c_7, imagick::COMPOSITE_OVER, 0, 0);
    }
    $c_8_code = $p_data[0]['product']['c_8_code'];
    $c_8_id = $p_data[0]['product']['c_8_id'];
    if($c_8_code>0){
      $c_8 = new Imagick(IMG_DIR."/material/".$c_8_id.".png");
      $c_8->resizeImage($publish_x, $publish_y, imagick::FILTER_MITCHELL, 1, false);
      $canvas->compositeImage($c_8, imagick::COMPOSITE_OVER, 0, 0);
    }
    $c_9_code = $p_data[0]['product']['c_9_code'];
    $c_9_id = $p_data[0]['product']['c_9_id'];
    if($c_9_code>0){
      $c_9 = new Imagick(IMG_DIR."/material/".$c_9_id.".png");
      $c_9->resizeImage($publish_x, $publish_y, imagick::FILTER_MITCHELL, 1, false);
      $canvas->compositeImage($c_9, imagick::COMPOSITE_OVER, 0, 0);
    }
    $c_10_code = $p_data[0]['product']['c_10_code'];
    $c_10_id = $p_data[0]['product']['c_10_id'];
    if($c_10_code>0){
      $c_10 = new Imagick(IMG_DIR."/material/".$c_10_id.".png");
      $c_10->resizeImage($publish_x, $publish_y, imagick::FILTER_MITCHELL, 1, false);
      $canvas->compositeImage($c_10, imagick::COMPOSITE_OVER, 0, 0);
    }
    if( is_dir(TOP_IMG_DIR.'/top/'.$member_code) ){
      $canvas->writeImage(TOP_IMG_DIR.'/top/'.$member_code."/".$product_code.".png");
    }else{
      if ( mkdir(TOP_IMG_DIR.'/top/'.$member_code,0777) ) {
        chmod(TOP_IMG_DIR.'/top/'.$member_code,0777);
        $canvas->writeImage(TOP_IMG_DIR.'/top/'.$member_code."/".$product_code.".png");
      } else {
        echo "";
      }
    }
  }

  function session_manage(){
    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['member_code'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}