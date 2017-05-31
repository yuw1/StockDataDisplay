<!DOCTYPE html>
<html lang="en">
  <head>
  	<meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>@yield('title')--股票分析网</title>

    <!-- Bootstrap -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/spinner.css')}}" rel="stylesheet">
   	<script type="text/javascript" src="{{asset('js/vue.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery-3.1.1.min.js')}}"></script>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  	
	<nav class="navbar navbar-inverse"  role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-responsive-collapse">
					<span class="sr-only"></span>
        	<span class="icon-bar"></span>
        	<span class="icon-bar"></span>
        	<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{url('/')}}">股票分析网</a>
			</div>
			<span class="collapse navbar-collapse navbar-responsive-collapse">
				<ul class="nav navbar-nav">
		
					
					<li @if (request()->path() == '/') class="active" @endif><a href="{{url('/')}}">公告数据总览</a></li>
					<li class="dropdown">
					  <a class="dropdown-toggle" data-toggle="dropdown" >
					       公告数据分析
					    <b class="caret"></b>
					  </a>
					  <ul class="dropdown-menu" >
					    <li><a href="/timeperiod">按时间周期查看</a></li>
					    <li role="separator" class="divider"></li>
					    <li><a href="/filter">按公告关键词筛选</a></li>
					    <li role="separator" class="divider"></li>
					    <li><a href="/change">区域企业变更分析</a></li>
					    <li role="separator" class="divider"></li>					    
					    <li><a href="/company">企业数据分析</a></li>
					  </ul>
					</li>
					<li @if (request()->path() == 'other') class="active" @endif><a href="{{url('/other')}}">其他数据分析</a></li>								
					
				</ul>
				<ul class="nav navbar-nav navbar-right"> 
            <li @if (request()->path() == 'note') class="active" @endif><a href="{{url('/note')}}">笔记</a></li>
						<li @if (request()->path() == 'console') class="active" @endif><a href="{{url('/console')}}">控制</a></li>
        </ul> 
			</span>
			
		</div>
		
	</nav>
	@yield('content')
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    
<div align="center">
	<script async src="//dn-lbstatics.qbox.me/busuanzi/2.3/busuanzi.pure.mini.js"></script>
	<span id="busuanzi_container_site_pv">
    本站总访问量<span id="busuanzi_value_site_pv"></span>次
</span>
<span id="busuanzi_container_site_uv">
  本站访客数<span id="busuanzi_value_site_uv"></span>人次
</span>
<div>Copyright &copy; 2017 by <a href="http://blog.wyu.space">WangYu</a></div>
</div>

  </body>
</html>