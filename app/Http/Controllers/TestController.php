<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
	function test()
	{
		$data = array("name" => "桂林");
			$data_string = json_encode($data);
			
			$ch = curl_init('http://www.wonmian.com/gupiao');
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			        'Content-Type: application/json',
			        'Content-Length: ' . strlen($data_string))
			);
			
			$result = curl_exec($ch);
			$result=json_decode($result);
			var_dump($result);
			$size = sizeof($result);
			$pageAll = ceil($size/15);
			$gonggao=array();
			print_r("");
			for($i=0;$i<4;$i++){
				$onegonggao=DB::select("select * from gonggao where Id ='".$result[$i]."'");
				$gonggao[]=$onegonggao[0];
			}
			var_dump($gonggao);
			
			$count=DB::select('select count(*) from gonggao');
    		$count=((array)($count[0]));
    		$count=$count["count(*)"];
    		$count=(int)($count);
    		$pageAll = ceil($count/15);
    		$gonggao = DB::select("select * from gonggao order by Gonggaoming desc limit 0, 15;");
			$data=[$gonggao,$count,$pageAll,1];
    		var_dump($gonggao);
	}
}
