<?php


class MuraCalShell extends Shell {

	var $uses = array('Muras');

	function main(){
        /* 実際の処理を書きます */
        /* $this->uses に追加したモデルが使用できます */
        //$lists = $this->Model->findAll();[
		echo "start";
		//現在の金額を取得する
		$data = $this->Muras->select_item_give_member();
		//var_dump($data);
		foreach($data as $datas){
			$now_kome = $datas['mura_member']['kome_amount'];
			$update_kome = $now_kome + 10;
			$mura_member_code = $datas['mura_member']['mura_member_code'];
			$this->Muras->update_member_kome($mura_member_code,$update_kome);
		}
	}
}