<?php $App = 'app' ?>
<?php
if(isset($_SESSION["USERTYPE"]))
{
	if($_SESSION["USERTYPE"] == 'admin' || $_SESSION["USERTYPE"] == 'superAdmin')
	{
		$App = 'app';
	}
	else
	{
		$App = 'appUser';
	}
	
}

?>
@extends($App)
@section('content')
<html>
	<head>
		<title>MOM</title>
		
		<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
		<link href="{{ asset('/css/momStyle.css') }}" rel='stylesheet' type='text/css'>
		<script src="{{ asset('/js/datetimepicker_css.js') }}" type="text/javascript"></script>
		<script language="JavaScript" src="{{ asset('/js/datetimepicker_css.js?random=20060118') }}"></script>
		<script type="text/javascript"  src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.js"></script>
		<!--<script type="text/javascript" src="{{ asset('/js/test.js') }}"></script>-->
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine">
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	 
	    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		
		<style>
@import "compass/css3";

*,*:after,*:before{
-webkit-box-sizing:border-box;
-moz-box-sizing:border-box;
-ms-box-sizing:border-box;
box-sizing:border-box;

}

body{
background: #fff;
  font-family: verdana;
}

section{
max-width:25em;
margin:0 auto;
margin-top:2%;
  
}

ul{
margin:0;
  padding: 0;
  list-style-type:none;
}
li{
position: relative;
}
h1{
display:block;
text-align: center;
background: #535c6f;
color:white;
  margin:0;
    padding: 0.75em 0;
  font-weight: normal;
  border-radius:5px 5px 0 0;
}

form{
  border-radius:0 0 5px 5px;
  border:1px solid #ccc;
  border-top: none;
  background: #fff;
  
}

ul li:not(:last-child){
display:block;
  border-bottom:1px solid #ccc;
  margin-bottom: 1em;
}

label{
display:block;
  font-size: .8125em; /* 13/16 */
    position: absolute;
    top: 1.6em;
    left: 1.4em;
    color: #f1773b;
    opacity: 1;
  transition:top 0.4s ease, opacity 0.6s ease , color 0.4s ease;
}

input,textarea{
  display:block;
width:100%;
  height:100%;
 border:0;
  outline:none;
  padding:2.25em 1em 1em;
  font-size: 1.2em;
  
}

textarea{
height:16em;
  resize:none;
  font-size: 1.2em;
  font-family: verdana;
  padding-left: 0.85em;
}
input[type="submit"]{
  display:block;
background:  #E8BE40;
  padding: 1em;
  color:white;
  text-transform: uppercase;
  cursor:pointer;
}

.js-hide-label label{
opacity:0;
  top:1.8em;
}

.js-unhighlight-label label{
color:#E8BE40;
}

.js-highlight-label label{
color:#E8BE40;
}


		</style>
		<script type="text/javascript">
		
        </script>
	</head>
	<body>
		<div id="titleBar">
			<h4>MOM CONTACT</h4>
		</div>
		<section class="container">
		    <h1 class="title">Contact OSS</h1>
		    <form id="form" class="form" action="{{ url('contactProcess') }}" method="post">
		        <ul>
		        	<input type="hidden" name="user_id" value="{{$_SESSION['dashboard_user_id']}}">
		            <li>
		                <label for="message">Message:</label>
		                <textarea placeholder="Message…" id="message" name="message" tabindex="3"></textarea>
		            </li>
		        </ul>
		        <input type="submit" value="Send Message" id="submit"/>
		    </form>
		</section>
	</body>
@endsection	