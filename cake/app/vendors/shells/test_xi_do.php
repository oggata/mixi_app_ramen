<?php


class TestXiDoShell extends Shell {

	var $uses = array('Procedure','SalesHistory','Members','MapPosition','Procedure','MPrefectureTaste','MemberMessage');

	function main(){
		echo "start";
		//現在の金額を取得する
		$test_member_mixi_account_code = array(1,2,3,4,5,6);

		foreach($test_member_mixi_account_code as $test_member_mixi_account_codes){
			echo $test_member_mixi_account_codes;
			$this->doaction($test_member_mixi_account_codes);
		}


		echo "end";

	}


	function doaction($member_code){
		//セッションから会員番号を取得
		//$member_code = $this->session_data['member_code'];
		$random = rand(1,5);
		//$random = 1;

		$data = $this->Members->select_member_detail($member_code);
		$target_code = $data[0]['members']['target_code'];
		$target_id = $data[0]['members']['target_id'];
		$map_code = $data[0]['members']['item_position_type_code'];

		$prefecture_code = $data[0]['members']['map_code'];
		$main_product_code = $data[0]['members']['main_product_code'];

		$a_1 = 29;
		$a_2 = 23;
		$a_3 = 16;
		$a_4 = 24;
		$a_5 = 31;
		$a_6 = 39;
		$a_7 = 45;
		$a_8 = 52;
		$a_9 = 58;
		$a_10 = 51;
		$a_11 = 43;
		$a_12 = 36;

		for($i=1;$i<13;$i++){
			if(${'a_'.$i}==$target_code){
				echo 'a_'.$i;
				$masu_place_code = $i;
			}
		}

		$moved_masu_place_code = $masu_place_code + $random;
		if($moved_masu_place_code > 12){
			$moved_masu_place_code = $moved_masu_place_code - 12;
		}

		$moved_masu_place_code = ${'a_'.$moved_masu_place_code};

		$map_pisition_detail = $this->MapPosition->select_map_detail_by_position_code($moved_masu_place_code,$map_code);
		$item_id = $map_pisition_detail[0]['map_position']['item_id'];

		//$this->Session->write("EventFlag",0);
		if($item_id == 'exp_plus'){
			//$this->Session->write("EventFlag",1);
			$data = $this->MapPosition->select_m_event_rand(3);
			$event_code = $data[0]['m_event']['event_code'];
			//$this->Session->write("EventTitle",'経験値アップ');
			//$this->Session->write("EventColor",'#0B85FF');
			//$this->Session->write("EventImg",'/img/human/upexp.png');
			$event_txt = $data[0]['m_event']['txt'].','.$data[0]['m_event']['target_point'].'ＥＸＰ↑';
			//$this->Session->write("EventTxt",$event_txt);
			//$this->Session->write("EventPoint",$data[0]['m_event']['target_point']);
			$this->Procedure->call_exp($member_code,$event_code);
		}elseif($item_id == 'exp_minus'){
			//$this->Session->write("EventFlag",1);
			$data = $this->MapPosition->select_m_event_rand(4);
			$event_code = $data[0]['m_event']['event_code'];
			//$this->Session->write("EventTitle",'経験値ダウン');
			//$this->Session->write("EventColor",'#CC3333');
			//$this->Session->write("EventImg",'/img/human/downexp.png');
			$event_txt = $data[0]['m_event']['txt'].','.$data[0]['m_event']['target_point'].'ＥＸＰ↓';
			//$this->Session->write("EventTxt",$event_txt);
			//$this->Session->write("EventPoint",$data[0]['m_event']['target_point']);
			$this->Procedure->call_exp($member_code,$event_code);
		}elseif($item_id == 'money_plus'){
			//$this->Session->write("EventFlag",1);
			$data = $this->MapPosition->select_m_event_rand(1);
			$event_code = $data[0]['m_event']['event_code'];
			//$this->Session->write("EventTitle",'お金アップ');
			//$this->Session->write("EventColor",'#0B85FF');
			//$this->Session->write("EventImg",'/img/human/getmoney.png');
			$event_txt = $data[0]['m_event']['txt'].','.$data[0]['m_event']['target_point'].'銭↑';
			//$this->Session->write("EventTxt",$event_txt);
			//$this->Session->write("EventPoint",$data[0]['m_event']['target_point']);
			$this->Procedure->call_money($member_code,$event_code);
		}elseif($item_id == 'money_minus'){
			//$this->Session->write("EventFlag",1);
			$data = $this->MapPosition->select_m_event_rand(2);
			$event_code = $data[0]['m_event']['event_code'];
			//$this->Session->write("EventTitle",'お金ダウン');
			//$this->Session->write("EventColor",'#CC3333');
			//$this->Session->write("EventImg",'/img/human/lostmoney.png');
			$event_txt = $data[0]['m_event']['txt'].','.$data[0]['m_event']['target_point'].'銭↓';
			//$this->Session->write("EventTxt",$event_txt);
			//$this->Session->write("EventPoint",$data[0]['m_event']['target_point']);
			$this->Procedure->call_money($member_code,$event_code);
		}elseif($item_id == 'warp'){
			//$this->Session->write("EventFlag",1);
			$jump_data = $this->jump_another_map();
			$prefecture_code = $jump_data[0]['member_town_taste']['member_code'];
			$prefecture_name = $jump_data[0]['member_town_taste']['member_name'];
			//$this->Session->write("EventTitle",'ワープしました！');
			//$this->Session->write("EventColor",'#F97C00');
			//$this->Session->write("EventImg",'/img/human/warp.png');
			//$this->Session->write("EventTxt",$prefecture_name.'町にワープしました。');
			//$this->Session->write("EventPoint",'0');
		}
		$this->Members->update_member_xi_number($member_code,$moved_masu_place_code,$random);
	}

	function jump_another_map(){
		//$this->session_manage();
		//セッションから会員番号を取得
		$member_code = $this->session_data['member_code'];
		$message_category = 1;
		//ジャンプ先をランダムで決める
		$jump_data = $this->MPrefectureTaste->select_prefecture_tasete_randam_one($member_code);
		$prefecture_code = $jump_data[0]['member_town_taste']['member_code'];
		$prefecture_name = $jump_data[0]['member_town_taste']['member_name'];
		$m_data = $this->Members->select_member_detail($member_code);
		$main_product_code = $m_data[0]['members']['main_product_code'];
		$member_name = $m_data[0]['members']['member_name'];

		//アイテムの配置タイプをランダムで選択する
		$map_position_data = $this->MapPosition->select_map_position_map_randam();
		$item_position_type_code = $map_position_data[0]['map_position']['map_code'];

		//ジャンプする
		$this->Members->update_member_map_code($member_code,$prefecture_code,$item_position_type_code);
		$message_txt = $prefecture_name.'にワープしました。';
		$max_point = '0';
		$sales_count = '0';

		//既にデータが存在しているか確認する
		$already_data = $this->SalesHistory->select_count_sales_history($member_code,$prefecture_code);
		$hisotry_data_count = $already_data[0][0]['count'];

		if($hisotry_data_count == 0){
			$this->SalesHistory->insert_sales_hisotry($member_code,$member_name,$prefecture_code,$prefecture_name,$max_point,$sales_count,$main_product_code);
		}else{
			$this->SalesHistory->update_sales_history($member_code,$prefecture_code);
		}
		$this->MemberMessage->insert_member_message($member_code,$message_category,$message_txt);
		return $jump_data;
	}

	function return_masu_jyunban($position_code){

			switch ($position_code) {
			case 1:
				return 1;
				break;
			case 2:
				return 2;
				break;
			case 3:
				return 3;
				break;
			case 4:
				return 4;
				break;
			case 5:
				return 5;
				break;
			case 6:
				return 6;
				break;
			case 7:
				return 7;
				break;
			}
	}

}