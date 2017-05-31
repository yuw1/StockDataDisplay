<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class OverViewController extends Controller
{
   
    public function OverView()
    {
    	//$gonggao = DB::select('select * from gonggao');
    	$count=DB::select('select count(*) from gonggao');
    	
    	$count=((array)($count[0]));
    	$count=$count["count(*)"];
    	$gonggao = DB::table('gonggao')
                ->orderBy('Gonggaoming', 'desc')->paginate(15);
        return view('overview',[
        	'gonggao'=>$gonggao,
        	'count'=>$count
        ]);
    }
    
    public function getList(Request $req)
    {
    	switch($req->mode)
    	{
    	case 'timeup':
    		$count=DB::select('select count(*) from gonggao');
    		$count=((array)($count[0]));
    		$count=$count["count(*)"];
    		$count=(int)($count);
    		$pageAll = ceil($count/15);
    		$gonggao = DB::select("select * from gonggao order by OrderDate asc limit ".((((int)$req->page-1)*15))." , 15;");
			$data=[$gonggao,$count,$pageAll,(int)$req->page];
    		return $data;
    		break;	
    	case 'timedesc':
    		$count=DB::select('select count(*) from gonggao');
    		$count=((array)($count[0]));
    		$count=$count["count(*)"];
    		$count=(int)($count);
    		$pageAll = ceil($count/15);
    		$gonggao = DB::select("select * from gonggao order by OrderDate desc limit ".((((int)$req->page-1)*15))." , 15;");
			$data=[$gonggao,$count,$pageAll,(int)$req->page];
    		return $data;
    		break;	
    	case 'nameup':
    		$count=DB::select('select count(*) from gonggao');
    		$count=((array)($count[0]));
    		$count=$count["count(*)"];
    		$count=(int)($count);
    		$pageAll = ceil($count/15);
    		$gonggao = DB::select("select * from gonggao order by Gonggaoming asc limit ".((((int)$req->page-1)*15))." , 15;");
			$data=[$gonggao,$count,$pageAll,(int)$req->page];
    		return $data;
    		break;	
    	case 'namedesc':
    		$count=DB::select('select count(*) from gonggao');
    		$count=((array)($count[0]));
    		$count=$count["count(*)"];
    		$count=(int)($count);
    		$pageAll = ceil($count/15);
    		$gonggao = DB::select("select * from gonggao order by Gonggaoming desc limit ".((((int)$req->page-1)*15))." , 15;");
			$data=[$gonggao,$count,$pageAll,(int)$req->page];
    		return $data;
    		break;	
    	case 'timeperiod':
//	    	$gonggao = DB::table('gonggao')
//	            ->whereBetween('OrderDate', [(string)($req->begin),(string)($req->end).' 23:59:59'])->get();
//  		return $gonggao;
//  		break;
    		$count=DB::select("select count(*) from gonggao where OrderDate BETWEEN '".(string)($req->begin)."' AND '".(string)($req->end).' 23:59:59'."'");
    		$count=((array)($count[0]));
    		$count=$count["count(*)"];
    		$count=(int)($count);
    		$pageAll = ceil($count/15);
    		$gonggao = DB::select("select * from gonggao where OrderDate BETWEEN '".(string)($req->begin)."' AND '".(string)($req->end).' 23:59:59'."' order by Gonggaoming desc limit ".((((int)$req->page-1)*15))." , 15;");
			$data=[$gonggao,$count,$pageAll,(int)$req->page];
    		return $data;
    		break;
    	case 'filter':
//  		$gonggao= DB::table('gonggao')
//          ->where('Gonggaoming', 'like', '%'.$req->keyword.'%')
//          ->get();
//          return $gonggao;
//  		break;

			$data = array("name" => $req->keyword);
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
			$count = sizeof($result);
			$pageAll = ceil($count/15);
			$gonggao=array();
			$first=(((int)$req->page-1)*15);
			$i=$first;
			$size = sizeof($result);
			
			if($result[0]==-1){
				return redirect()->view('notfound');
			}else if($result[0]==0){
				return redirect()->view('overtime');
			}else{
				while($i<$size&&$i<$first+15)
				{
					$onegonggao=DB::select("select * from gonggao where Id ='".$result[$i]."'");
					$gonggao[]=$onegonggao[0];
					$i=$i+1;
				}
			}
			
			
			
//  		$count=DB::select("select count(*) from gonggao where Gonggaoming like '%".$req->keyword."%'");
//  		$count=((array)($count[0]));
//  		$count=$count["count(*)"];
//  		$count=(int)($count);
//  		$pageAll = ceil($count/15);
//  		$gonggao = DB::select("select * from gonggao where Gonggaoming like '%".$req->keyword."%' order by Gonggaoming desc limit ".((((int)$req->page-1)*15))." , 15;");
			$data=[$gonggao,$count,$pageAll,(int)$req->page];
			//var_dump($data);
    		return $data;
    		break;
    	case 'mapfilter':
   
    		$data = array("name" => $req->keyword);
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
			$size = sizeof($result);
			$i = 0;
			$gonggao=array();
			while($i<$size)
			{
				$onegonggao=DB::select("select * from gonggao where Id ='".$result[$i]."'");
				$gonggao[]=$onegonggao[0];
				$i=$i+1;
				
			}
			return $gonggao;
    		break;
    	case 'companyInfo':
    		$data = DB::select("select * from cleared where province = '".$req->keyword."'");
   			return $data;
   			break;
    	}
    	
    	
    	
    }
    public function change()
    {
    	$data = DB::select("select * from cleared where province = '上海市'");
    	
   		return view('change',[
   			'data'=>$data
   		]);
   		
    }
}


?>