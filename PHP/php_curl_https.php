<?php
	set_time_limit(0);
	function buy()
	{
		$url = 'https://fubon-ebrokerdj.fbs.com.tw/Z/ZG/ZG_D.djhtm';
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		// 設定頭資訊（當用IP直接訪問時，加這個如：https://baibu.com -> 220.15.23.5）
		// curl_setopt($ci, CURLOPT_HTTPHEADER, array('Host:baibu.com'));
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //這個是重點,規避ssl的證書檢查。
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 跳過host驗證
		$data = curl_exec($curl);
		curl_close($curl);

		$myfile = fopen("buy.txt", "w") or die("Unable to open file!");
		fwrite($myfile, $data);
		fclose($myfile);
		//var_dump($data);	
	}


	function sell()
	{
	$url = 'https://fubon-ebrokerdj.fbs.com.tw/Z/ZG/ZG_D.djhtm';
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_HEADER, 1);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	// 設定頭資訊（當用IP直接訪問時，加這個如：https://baibu.com -> 220.15.23.5）
	// curl_setopt($ci, CURLOPT_HTTPHEADER, array('Host:baibu.com'));
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //這個是重點,規避ssl的證書檢查。
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 跳過host驗證
	$data = curl_exec($curl);
	curl_close($curl);

	$myfile = fopen("sell.txt", "w") or die("Unable to open file!");
	fwrite($myfile, $data);
	fclose($myfile);
	//var_dump($data);		
	}

	function get_money_New($ID)
	{
		$url = 'https://fubon-ebrokerdj.fbs.com.tw/z/zc/zcw/zcw1_'.$ID.'.djhtm';
		$file = fopen("url.txt", "w");
		fwrite($file,$url);
		fclose($file);
		exec("money.exe");
		Sleep(10);
	}
	
	function get_money($ID)
	{
		$url = 'https://fubon-ebrokerdj.fbs.com.tw/z/zc/zcw/zcw1_'.$ID.'.djhtm';
		if(file_exists('123.js'))
		{
            unlink('123.js');//將檔案刪除
		}
		if(file_exists('github.png'))
		{
			unlink('github.png');//將檔案刪除
		}
		if(file_exists('money.txt'))
		{
			unlink('money.txt');//將檔案刪除
		}
	
		$file_js = fopen("123.js", "w");
		$str = "var page = require('webpage').create();";
		fwrite($file_js,$str."\r\n");
		
		$str = "var url = '".$url."';";
		fwrite($file_js,$str."\r\n");
		
		$str = "page.open(url, function (status) {";
		fwrite($file_js,$str."\r\n");
				
		$str ="page.render('github.png');";
		fwrite($file_js,$str."\r\n");
		
		$str = "console.log(page.content);";
		fwrite($file_js,$str."\r\n");
		
		$str ="phantom.exit();";
		fwrite($file_js,$str."\r\n");
		
		$str ="});";
		fwrite($file_js,$str."\r\n");
		fclose($file_js);
		
		//echo $url."\r\n";
		system("phantomjs.exe 123.js > money.txt");
		Sleep(10);
	}
	
	function parse_money($filename)
	{
		if(file_exists($filename))
		{
			$file = fopen($filename, "r");
			while (!feof($file))
			{
				$str = fgets($file);//每次讀一行並做字串的相加
				//$str = mb_convert_encoding($str,"big5","utf-8");
				$buf = '<div class="AdapterK" id="SysJustWebGraphDIV" style="margin: 0px auto; width: 550px; min-height: 600px;" mcht="adp_1"><div tabindex="0" class="FundView opsView1 opsPC" style="width: 550px; min-height: 530px;"><div class="opsPoster" style="display: none;"></div><div class="opsView"><div class="opsHead opsWrap"><div class="opsNote" style="max-width: 430px;"><div class="notehead" style="display: inline-block;">';
				if(strpos($str,$buf)!== false)
				{
					$str = str_replace($buf,"",$str);
					$str = str_replace("<span>",",",$str);
					$str = str_replace("</span>",",",$str);
					break;
				}		
			}
			
			$Data= explode(",",$str);
			//print_r($Data);
			
			fclose($file);
			
			/*
			if(file_exists('123.js'))
			{
				unlink('123.js');//將檔案刪除
			}
			if(file_exists('github.png'))
			{
				unlink('github.png');//將檔案刪除
			}
			if(file_exists($filename))
			{
				unlink($filename);//將檔案刪除
			}
			*/
			
			//echo $Data[1].','.$Data[3].','.$Data[5].','.$Data[7]."\r\n";
			return $Data[3].','.$Data[5].','.$Data[7].',';
		}
		
		
			
	}

	function spilt_buy($filename)
	{
		$count=0;
		if(file_exists($filename))
		{
			$file = fopen($filename, "r");
			$file_s= fopen("Data_buy.txt", "w");
			if($file != NULL)
			{
				//當檔案未執行到最後一筆，迴圈繼續執行(fgets一次抓一行)
				while (!feof($file))
				{
					$buf='<td class="t3t1">&nbsp;<a href="javascript:Link2Stk(';
					$str = fgets($file);//每次讀一行並做字串的相加
					if(strpos($str,$buf)!== false)
					{
						$count++;
						$str = str_replace($buf."'","",$str);
						$str = str_replace("')\">",",",$str);
						$str = str_replace("</a></td>",",",$str);
						$str = str_replace("\r\n","",$str);
						$ID= explode(",",$str);
						//get_money($ID[0]);			
						//$str .= ",".parse_money("money.txt");
						
						get_money_New($ID[0]);//$str .="https://tw.stock.yahoo.com/q/bc?s=".$ID[0];
						$str .= ",".parse_money("money.txt");
						
						fwrite($file_s,$str."\r\n");//寫入字串

						if($count>29)
						{
							break;							
						}
					}
				}
				
				fclose($file);
				fclose($file_s);
			}
		}		
	}

	function spilt_sell($filename)
	{
		$count=0;
		if(file_exists($filename))
		{
			$file = fopen($filename, "r");
			$file_s= fopen("Data_sell.txt", "w");
			if($file != NULL)
			{
				//當檔案未執行到最後一筆，迴圈繼續執行(fgets一次抓一行)
				while (!feof($file))
				{
					$buf='<td class="t3t1">&nbsp;<a href="javascript:Link2Stk(';
					$str = fgets($file);//每次讀一行並做字串的相加
					if(strpos($str,$buf)!== false)
					{
						$count++;
						$str = str_replace($buf."'","",$str);
						$str = str_replace("')\">",",",$str);
						$str = str_replace("</a></td>",",",$str);
						$str = str_replace("\r\n","",$str);
						$ID= explode(",",$str);
						//get_money($ID[0]);
						//$str .= ",".parse_money("money.txt");
						
						get_money_New($ID[0]);//$str .="https://tw.stock.yahoo.com/q/bc?s=".$ID[0];
						$str .= ",".parse_money("money.txt");

						
						fwrite($file_s,$str."\r\n");//寫入字串

						if($count>29)
						{
							break;							
						}
					}
				}
				
				fclose($file);
				fclose($file_s);
			}
		}		
	}
	
	buy();
	sell();
	spilt_buy("buy.txt");
	spilt_sell("sell.txt");
	unlink('buy.txt');
	unlink('sell.txt');
	echo 'donload finish...'
?>