@extends('layouts.main')
@section('title','按公告关键词筛选')
@section('content')
<div id="vue">
	<div>
		&nbsp;&nbsp;<input id="keyword" type="text" placeholder="请输入关键词"/>
		<button type="button" class="btn btn-info" v-on:click="find">查找</button><br /><br />
	</div>
	<div class="panel panel-default">
			<div class="panel-heading">按公告关键词筛选</div>
			<div class="panel-body">
				<table class="table table-striped table-bordered table-hover">
				  <thead>
				    <tr>
				      <th>名称</th>
				      <th>收录时间</th>
				      <th>操作</th>
				    </tr>
				  </thead>
				  <tbody>
				    <tr v-for="data in datas">
				      <td id="name">@{{data.Gonggaoming}}</td>
				      <td id="time">@{{data.OrderDate}}</td>
				      <td id="operate"><a v-bind:href="data.Urlpath" download>下载</a>&nbsp;&nbsp;<a v-bind:href="data.Urlpath" target="_blank">预览</a></td>
				    </tr>
				  </tbody>
				  
				</table>
			</div>
			<!--<ul class="pagination">
				    <li><a href="#">&laquo;</a></li>
				    <li><a href="#">1</a></li>
				    <li><a href="#">2</a></li>
				    <li><a href="#">3</a></li>
				    <li><a href="#">4</a></li>
				    <li><a href="#">5</a></li>
				    <li><a href="#">&raquo;</a></li>
		    </ul>-->
		    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;第<select class="selectpicker show-tick " id="setpage">
				<option v-for=" i in pageAll">@{{i}}</option></div>					  
			</select>页
			<button type="button" class="btn btn-large btn-info" v-on:click="jumppage">跳转</button>
	</div>
</div>
<div class="spinner" style="display: none;" id="loading">
  <div class="rect1"></div>
  <div class="rect2"></div>
  <div class="rect3"></div>
  <div class="rect4"></div>
  <div class="rect5"></div>
    正在飞速加载
</div>
<script type="text/javascript" src="{{asset('js/vue.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
<script type="text/javascript">
	var operate = new Vue({
	    el: "#vue",
	    data: {
	      datas:[
	      	{Gonggaoming:'',OrderDate:'',Urlpath:''}
	      ],
	      pageAll:1,
	      page:1
	    },
	    methods: {
	    	jumppage:function(){
	    		var _self=this;
	    		_self.page = $("#setpage").val();
	    		this.find();
	    	},
	    	
		    find:function(){
		    	document.getElementById('loading').style.display = 'block';
		    	var setmode = event.target;
		    	var _self = this;
//		    	mode = setmode.id.toString();
		        $.ajax({						
                        type: "post",
                        url: "/getList",
                        data:{mode:"filter",keyword:$("#keyword").val(),page:_self.page},
                        error:function(){
                      
                        },
                        success: function(datas) {     
                        	 document.getElementById('loading').style.display = 'none';                           	 
                            _self.datas = datas[0];
                            _self.pageAll=datas[2];
                            function setSelectChecked(selectId, checkValue){  
							    var select = document.getElementById("setpage");  
							    for(var i=0; i<select.options.length; i++){  
							        if(select.options[i].innerHTML == 1){  
							            select.options[i].selected = true;  
							            break;  
							        }  
							    }  
							}; 
                            
                                     
                        }
                   });
		    }	      
	    }
	});
</script>
	
@endsection('content')