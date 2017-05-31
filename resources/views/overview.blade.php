@extends('layouts.main')
@section('title','公告数据总览')
@section('content')
<h2>&nbsp;&nbsp;从2017年4月1日到现在，系统已收集公告数量{{$count}}篇</h2>
<div id="vue">
	<div class="btn-group col-md-4" id="input">
	    <button type="button" class="btn btn-large btn-info" autofocus="autofocus" v-on:click="find" id="timeup">按时间升序</button>
	    <button type="button" class="btn btn-large btn-info" v-on:click="find" id="timedesc">按时间降序</button>
	    <button type="button" class="btn btn-large btn-info" v-on:click="find" id="nameup">按名称升序</button>
	    <button type="button" class="btn btn-large btn-info" v-on:click="find" id="namedesc">按名称降序</button>
	</div>
	<!--<input type="text" id="mode"/>-->

	<br /><br />
	<div class="panel panel-default">
		<div class="panel-heading" >已收集的公告</div>
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
			      <td v-text="data.Gonggaoming"></td>
			      <td v-text="data.OrderDate"></td>
			      <td id="operate"><a v-bind:href="data.Urlpath" download>下载</a>&nbsp;&nbsp;<a v-bind:href="data.Urlpath" target="_blank">预览</a></td>
			    </tr>
			  </tbody>
			  
			</table>
		</div>
		<!--<ul class="pagination" >
		    <li><a href="#">&laquo;</a></li>
		    <li v-for="i in pageAll"><a v-text="i" v-on:click="page" v-bind:id="i"></a></li>		    
		    <li><a href="#">&raquo;</a></li>
		</ul>-->
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;第<select class="selectpicker show-tick " id="setpage">
			<option v-for=" i in pageAll">@{{i}}</option>				  
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
	      page:1,
	      mode:''
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
		    	if(setmode.id!='')
		    	{
		    		_self.mode = setmode.id.toString();
		    	}
		        $.ajax({						
                        type: "post",
                        url: "/getList",
                        data:{mode:_self.mode,page:_self.page},
                        error:function(){
                        	alert('失败！')
                        },
                        success: function(datas) {                        	 
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
                            
                            document.getElementById('loading').style.display = 'none';                  
                        }
                   });
		    }	      
	    }
	});
 $("#timeup").click();
</script>


@endsection('content')