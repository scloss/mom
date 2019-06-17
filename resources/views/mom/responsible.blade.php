<html>
<head>

<title>Responsible List</title>


<!-- Bootstrap Core JavaScript -->
<script src="js/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
   <script src="js/bootstrap.min.js"></script>
   
<!-- Placed js at the end of the document so the pages load faster -->
<script src="js/angular.min.js"></script>
<script>
var emailValues='';
function emailfunction(id,value){
  var values = "<?php echo $_GET['responsibleID'] ?>";
  
  if(value == 'add'){
  	document.getElementById(id).style.backgroundColor = "#3cb0fd";
	document.getElementById(id).style.color = "#fff";
  	//emailValues += id+',';
  	var checkList = document.getElementById("checkList[]");
  	$(checkList).append('<option value="'+id+'">'+id+'</option>');
  }
  if(value == 'submitCustom'){
 //  	document.getElementById(id).style.backgroundColor = "#3cb0fd";
	// document.getElementById(id).style.color = "#fff";
  	//emailValues += id+',';
  	var checkList = document.getElementById("checkList[]");
  	var customValue = document.getElementById("customEmail").value;
  	var res = customValue.split("@");

	if(res.length > 1){
		if(res[1] == 'summitcommunications.net'){
			alert('Please do not assign SCL group mail address in responsible.For internal address use below field ');
		}
		else{
			var filter = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			if(filter.test(customValue)){
		  		$(checkList).append('<option value="'+customValue+'">'+customValue+'</option>');
		  	}
		}
	}
  }
  if(value == 'submit'){
  	$("select option").each(function() { 
  		emailValues += $(this).text()+',';
	});
  	if(emailValues == ''){
		alert("Please Add at least one");
	}
	else{
		var emailArr = emailValues.split(",");
		var uniqueNames = [];
		$.each(emailArr, function(i, el){
		    if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
		});
		//emailArr = unique(emailArr);

		emailVal = uniqueNames.join(',');
		emailStr = emailVal.slice(0,-1);
		//alert(emailStr);
	  	window.opener.document.forms['meetingForm'].elements[values].value=emailStr;
	  
	  	window.close();
		// emailValues = emailValues.slice(0,-1);
	 //  	window.opener.document.forms['meetingForm'].elements[values].value=emailValues;
	  
	 //  	window.close();
	}
  }
  
    // alert(empname);


  }
  function removeResponsible() {
	    var x = document.getElementById("checkList[]");
	    x.remove(x.selectedIndex);
	}
</script>

<style>
table{
	margin-top:10%;
}
table, th , td  {
  border: 1px solid grey;
  border-collapse: collapse;
  padding: 5px;
  cursor: pointer;
}
table tr:nth-child(odd) {
  background-color: #f1f1f1;
}
table tr:nth-child(even) {
  background-color: #ffffff;
}
</style>
<body>
<div class="container">
	<div class="col-md-6">
		<div ng-app="momApp" ng-controller="userCtrl">
		 
			<table>
			  <tr>
			  	<td>
			  		Use below field to add external email address
			  	</td>
			  </tr>		
			  <tr>
			  	<td><input type="text" name="customEmail" id="customEmail" value="" placeholder="For External Email"><button id="submit" onclick="emailfunction(this.id,'submitCustom');">SUBMIT</button></td>
			  </tr>
			  <tr>
			  	<td><input type="text" ng-model="search" style="width: 100%;border-radius:5px;color:#000;" placeholder="Search"></td>
			  	
			  </tr>
			  <tr ng-repeat="emailID in emailIDs | filter:search">
			    <td id="@{{emailID.email}}" onclick="emailfunction(this.id,'add');" style="padding:10px;">@{{ emailID.email }} (@{{emailID.designation}}) (@{{emailID.dept}})</td>
			  </tr>

			</table>
		 
		</div>
	</div>
	<div class="col-md-6">
		<table>
			<tr>
				<td>
					<select id="checkList[]" name="checkList[]" multiple style="height:220px !important;width:380px;">		   
					</select>
				</td>

			</tr>
			<tr>
				<td>
					<center>
						<button id="submit" onclick="emailfunction(this.id,'submit');">SUBMIT</button>
						<button onclick="removeResponsible()">Remove Selected Person</button>
					</center>
				</td>  
			</tr>
		</table>
	</div>
</div>
 
<script>
var app = angular.module('momApp', []);
app.controller('userCtrl', function($scope, $http) {
   $http.get("{{ url('userApi') }}")
   .then(function (response) {$scope.emailIDs = response.data.records;});
});
</script>
</html>
