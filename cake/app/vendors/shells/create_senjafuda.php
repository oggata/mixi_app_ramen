<?php


class CreateSenjafudaShell extends Shell {

	var $uses = array('MPrefecture');

	function main(){
        /* 実際の処理を書きます */
        /* $this->uses に追加したモデルが使用できます */
        //$lists = $this->Model->findAll();[
		echo "start";
		$data = $this->MPrefecture->select_city_name_for_fuda();

		foreach($data as $datas){

			$random = rand(1,30);



			$canvas = new Imagick();
			$city_code = $datas['m_city']['city_code'];
			$city_name = $datas['m_city']['city_name'];

/*			echo '|';
			echo $city_code;
			echo $city_name;
			echo strlen($city_name);
			echo '|';
*/

			$char_length = strlen($city_name);
			//3文字

			if($char_length >= 24){
				$FontSize = 10;
				$StrokeWidth = 1;
				$FontColor = "#000000";
				$StartPosition = 5;
				//$city_name = substr($city_name, 0, 6);
			}else if($char_length >= 18){
				$FontSize = 12;
				$StrokeWidth = 1;
				$FontColor = "#000000";
				$StartPosition = 3;
			}else if($char_length >= 12){
				$FontSize = 16;
				$StrokeWidth = 1;
				$FontColor = "#000000";
				$StartPosition = 2;
			}else if($char_length >= 10){
				$FontSize = 17;
				$StrokeWidth = 1;
				$FontColor = "#000000";
				$StartPosition = 0;
			}else if($char_length >= 6){
				$FontSize = 18;
				$StrokeWidth = 1;
				$FontColor = "#000000";
				$StartPosition = 10;
			}


			$width = 80;
			$height = 30;
			$canvas->newImage($width, $height, new ImagickPixel("white"));
			$canvas->setImageFormat("jpg");

			$im = new Imagick(IMG_DIR."/fuda/moto/".$random.".png");
			$canvas->compositeImage($im, imagick::COMPOSITE_OVER, 0, 0);

			$idraw = new ImagickDraw();
			$idraw->setFont(FONT_DIR."/DC-YoseMoji-W7.ttc");
			$idraw->setFontSize($FontSize);
			$idraw->setFillColor($FontColor);
			//$idraw->setStrokeColor($FontColor);
			//$idraw->setStrokeWidth($StrokeWidth);

			$idraw->annotation($StartPosition,20,$city_name);
			$canvas->drawImage($idraw);
			$canvas->writeImage(IMG_DIR."/fuda/".$city_code.".jpg");

		}
	}
}