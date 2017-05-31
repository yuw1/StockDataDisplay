@extends('layouts.main')
@section('title','区域变更分析页')
@section('content')
<style type="text/css">  
html{height:100%}  
body{height:100%;margin:0px;padding:0px}  

#container{height:85%}  
</style>  
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=TwoUObeLfFBPbw11DgitVWDeovr5gI8P">

</script>
<script type="text/javascript">
	var companyName = new Array()

	var x = new Array();
	var y = new Array();
</script>
@foreach ($data as $adata)
	<script type="text/javascript">
		var aname="{{$adata->name}}";
		
 		companyName.push(aname);
		x.push({{$adata->locationX}});
		y.push({{$adata->locationY}});
	</script>
@endforeach
<h4>选择要查找的省份</h4><select id="select" name="province" onchange="change()">
    <option value="北京市">北京市</option>
    <option value="上海市" selected="selected">上海市</option>
    <option value="天津市">天津市</option>
    <option value="重庆市">重庆市</option>
    <option value="香港特别行政区">香港特别行政区</option>
    <option value="澳门特别行政区">澳门特别行政区</option>
    <option value="黑龙江省">黑龙江省</option>
    <option value="吉林省">吉林省</option>
    <option value="辽宁省">辽宁省</option>
    <option value="内蒙古">内蒙古</option>
    <option value="河北省">河北省</option>
    <option value="河南省">河南省</option>
    <option value="山东省">山东省</option>
    <option value="山西省">山西省</option>
    <option value="江苏省">江苏省</option>
    <option value="安徽省">安徽省</option>
    <option value="陕西省">陕西省</option>
    <option value="宁夏回族自治区">宁夏回族自治区</option>
    <option value="甘肃省">甘肃省</option>
    <option value="青海省">青海省</option>
    <option value="湖北省">湖北省</option>
    <option value="湖南省">湖南省</option>
    <option value="浙江省">浙江省</option>
    <option value="江西省">江西省</option>
    <option value="福建省">福建省</option>
    <option value="贵州省">贵州省</option>
    <option value="四川省">四川省</option>
    <option value="广东省">广东省</option>
    <option value="广西壮族自治区">广西壮族自治区</option>
    <option value="云南省">云南省</option>
    <option value="海南省">海南省</option>
    <option value="新疆维吾尔自治区">新疆维吾尔自治区</option>
    <option value="西藏自治区">西藏自治区</option>
</select>
                   
<div id="container"></div> 
<script type="text/javascript"> 
	var map = new BMap.Map("container");
	var point = new Array();
	var marker = new Array();  
	var point1 = new BMap.Point(121.487, 31.249);  
	map.centerAndZoom(point1, 9); 
	map.addControl(new BMap.NavigationControl());    
	map.addControl(new BMap.ScaleControl());    
	map.addControl(new BMap.OverviewMapControl());    
	map.addControl(new BMap.MapTypeControl());    
	map.enableScrollWheelZoom();
//	map.setCurrentCity("上海");
	for(var i = 0;i<x.length;i++){
		point.push(new BMap.Point(y[i], x[i])) ; 		
		marker.push(new BMap.Marker(point[i])); 
		marker[i].setTitle(companyName[i]); 
		      // 创建标注      
		map.addOverlay(marker[i]);
		marker[i].enableMassClear();
	
		marker[i].addEventListener("click", function(){
			var opts = {    
			 width : 250,     // 信息窗口宽度    
			 height: 100,     // 信息窗口高度    
			 title : this.getTitle()// 信息窗口标题   
			}  
			var content = ""; 
			$.ajax({						
                        type: "post",
                        url: "/getList",
                        data:{mode:"mapfilter",keyword:this.getTitle()},
                        error:function(){
                      
                        },
                        async : false,
                        success: function(datas) {                                	 
                            var datas = datas;
                            for(var i =0;i<datas.length;i++){
                            	content = content +"<a target=\"_blank\" href = '"+datas[i].Urlpath+"'>"+datas[i].Gonggaoming+"</a><br />"
                            }
                            
                                     
                        }
                   });
			var infoWindow = new BMap.InfoWindow("", opts);  // 创建信息窗口对象    
			infoWindow.setContent(content);
			map.openInfoWindow(infoWindow, this.getPosition());  
			
		},false);
		
	}
	function change(){
		map.clearOverlays();
		map.setCenter( $("#select").val());
		map.setZoom(9);
		companyName.splice(0,companyName.length);
		x.splice(0,x.length);
		y.splice(0,y.length);
		point.splice(0,point.length);
		marker.splice(0,marker.length);
		$.ajax({						
                        type: "post",
                        url: "/getList",
                        data:{mode:"companyInfo",keyword:$("#select").val()},
                        error:function(){
                      
                        },
                        async : false,
                        success: function(datas) {                                	 
                            var datas = datas;
                            for(var i = 0;i<datas.length;i++){
                            	companyName.push(datas[i].name);
								x.push(datas[i].locationX);
								y.push(datas[i].locationY);
                            }
                            for(var i = 0;i<x.length;i++){
								point.push(new BMap.Point(y[i], x[i])) ; 		
								marker.push(new BMap.Marker(point[i])); 
								marker[i].setTitle(companyName[i]);       // 创建标注      
								map.addOverlay(marker[i]);
							
								marker[i].addEventListener("click", function(){
									var opts = {    
									 width : 250,     // 信息窗口宽度    
									 height: 100,     // 信息窗口高度    
									 title : this.getTitle()// 信息窗口标题   
									}  
									var content = ""; 
									$.ajax({						
						                        type: "post",
						                        url: "/getList",
						                        data:{mode:"mapfilter",keyword:this.getTitle()},
						                        error:function(){
						                      
						                        },
						                        async : false,
						                        success: function(datas) {                                	 
						                            var datas = datas;
						                            for(var i =0;i<datas.length;i++){
						                            	content = content +"<a target=\"_blank\" href = '"+datas[i].Urlpath+"'>"+datas[i].Gonggaoming+"</a><br />"
						                            }
						                            
						                                     
						                        }
						                   });
									var infoWindow = new BMap.InfoWindow("", opts);  // 创建信息窗口对象    
									infoWindow.setContent(content);
									map.openInfoWindow(infoWindow, this.getPosition());  
									
								},false);
							}
                            
                                     
                        }
                   });
	}	
</script>

@endsection('content')