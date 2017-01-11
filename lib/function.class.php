<?php
		function skip($url){
			header("location:$url");
	}

		function show($code,$type=''){
			if($type==''){
				$type=0;
			}
			echo '<pre>';
			if($type==0)
				var_dump($code);
			else if($type==1)
				print_r($code);
			else
				echo ($code);
			echo '</pre>';
		}

		function nowtime(){
		date("Y-m-d H:i:s");
		return date("Y-m-d H:i:s");
}

		function decodejson($data){
		$data=json_decode(urldecode($data),true);
		return $data;
}
		function encodejson($data){
			$data=urlencode(json_encode($data));
		
		return $data;
		}

		function is_preg($array){
	
        if(!empty($array[0]) && $array[0] != ''){
			
            return TRUE;
        }else{
			
				
            return FALSE;
        }
    }

		
?>