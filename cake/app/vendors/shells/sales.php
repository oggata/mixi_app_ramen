<?php


class SalesShell extends Shell {

	var $uses = array('Procedure');

	function main(){
        /* 実際の処理を書きます */
        /* $this->uses に追加したモデルが使用できます */
        //$lists = $this->Model->findAll();[
		echo "start";
		//現在の金額を取得する
		$data = $this->Procedure->call_sales_exe();
		echo "end";

	}
}