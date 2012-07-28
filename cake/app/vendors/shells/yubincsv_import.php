<?php


class YubincsvImportShell extends Shell {

	var $uses = array('Product');

	function main(){
        /* 実際の処理を書きます */
        /* $this->uses に追加したモデルが使用できます */
        //$lists = $this->Model->findAll();[
		echo "start";
		//現在の金額を取得する
		$data_import_dir =  '/var/www/html/ramen/cake/app/webroot/csv/3.csv';
		$handle = @fopen($data_import_dir, "r");
		if ($handle) {
			$data_no = 0;
		    while ($csv[] = fgetcsv($handle, "1024")) {
				$postcode = $csv[$data_no][2];
				$prefecture_name= mb_convert_encoding($csv[$data_no][6], "UTF-8", 'SJIS');
				$city_name= mb_convert_encoding($csv[$data_no][7], "UTF-8", 'SJIS');
				$town_name= mb_convert_encoding($csv[$data_no][8], "UTF-8", 'SJIS');
				$prefecture_kana= mb_convert_encoding($csv[$data_no][3], "UTF-8", 'SJIS');
				$city_kana= mb_convert_encoding($csv[$data_no][4], "UTF-8", 'SJIS');
				$town_kana= mb_convert_encoding($csv[$data_no][5], "UTF-8", 'SJIS');
				$data_no = $data_no + 1;
				//echo $city_name;
				$this->Product->insert_into_m_postcode($postcode,$prefecture_name,$city_name,$town_name,$prefecture_kana,$city_kana,$town_kana);
		    }
		    fclose($handle);
		}
		echo "end";
	}
}