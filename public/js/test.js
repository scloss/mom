var counter = 1;
var recipient_arr_src = new Array();

var exitValue = "There is unsaved data in this page";
function closeIt(event)
{
  return '';
}

window.onbeforeunload =  function(event) {
	//event.returnValue = null;
	return exitValue;
}

function getFormattedDate(){
    var d = new Date();

	d = d.getFullYear() + "-" + ('0' + (d.getMonth() + 1)).slice(-2) + "-" + ('0' + d.getDate()).slice(-2) + " " + ('0' + d.getHours()).slice(-2) + ":" + ('0' + d.getMinutes()).slice(-2) + ":" + ('0' + d.getSeconds()).slice(-2);
	return d;
}

// alert(getFormattedDate());
  
function createMom()
{ //on add input button click
        //momClicked = 1;
		//divName="dynamicInput";
  
	 //    var newdiv = document.createElement('div');
	 //    newdiv.innerHTML = "Entry " + (counter + 1) + " <br><input type='text' name='myInputs"+counter+"'>";
	 //    td
	 //    document.getElementById(divName).appendChild(newdiv);

	   	formDivName = "formDiv";
	   	var divName = "div"+counter;
	   	var dynamicDiv = document.createElement('div');


	   	dynamicDiv.setAttribute("id", divName);
	   	dynamicDiv.style.minWidth  = "1320px";
	   	dynamicDiv.style.overflowX = "auto";

	 //   	var mom_label_id = "mom_label"+counter;
	 //   	var mom_label = document.createElement('h4');
	 //   	var label_mom = document.createTextNode('MoM - '+counter);
	 //   	mom_label.setAttribute("id", mom_label_id);
		// mom_label.appendChild(label_mom);
	 //   	dynamicDiv.appendChild(mom_label);

	   	/********************/
	   	var table = document.createElement("TABLE");
	    table.setAttribute("id", "momTable");
	    table.style.minWidth = "1320px";
	    table.style.overflowX = "auto";


	    var mom_label_id = "mom_label"+counter;
	    var labelTr = document.createElement("TR");
	    labelTr.setAttribute("id", "mom_label_id");
	    

	    var label_mom = document.createTextNode('New Action Point - '+counter);
	    var labelTd = document.createElement("TD");
	    labelTd.setAttribute('colspan','8');
	    labelTd.setAttribute("id", mom_label_id);
	   	labelTd.appendChild(label_mom);

	   	labelTr.appendChild(labelTd);
	   	table.appendChild(labelTr);

	    var titlesTr = document.createElement("TR");
	    titlesTr.setAttribute("id", "titlesTr");
	    

	    var label_Title = document.createTextNode('Title');
	    var titleTd = document.createElement("TD");
	   	titleTd.appendChild(label_Title);

	   	titlesTr.appendChild(titleTd);


	    var responsible_Title = document.createTextNode('Responsible');
	    var responsibleTd = document.createElement("TD"); 
	   	responsibleTd.appendChild(responsible_Title);
	   	titlesTr.appendChild(responsibleTd);

	   	var start_time_title = document.createTextNode('Start Time');
	    var start_timeTd = document.createElement("TD");
	   	start_timeTd.appendChild(start_time_title);
	   	titlesTr.appendChild(start_timeTd);
 	
	    var end_time_title = document.createTextNode('End Time');
	    var end_timeTd = document.createElement("TD");
	   	end_timeTd.appendChild(end_time_title);
	   	titlesTr.appendChild(end_timeTd);

	   	var status_title = document.createTextNode('Status');
	    var status_Td = document.createElement("TD");
	   	status_Td.appendChild(status_title);
	   	titlesTr.appendChild(status_Td);

	   	var completion_status_title = document.createTextNode('Completion Status');
	    var completion_status_Td = document.createElement("TD");
	   	completion_status_Td.appendChild(completion_status_title);
	   	titlesTr.appendChild(completion_status_Td);

	   	var comment_title = document.createTextNode('Comment/Description');
	    var comment_Td = document.createElement("TD");
	   	comment_Td.appendChild(comment_title);
	   	titlesTr.appendChild(comment_Td);
	    
	    var blank_Td = document.createElement("TD");
	   	titlesTr.appendChild(blank_Td);
	    
	   	table.appendChild(titlesTr);


	   	var dataTr = document.createElement("TR");
	    dataTr.setAttribute("id", "dataTr");




	   	var title = "mom_title"+counter;
	    var mom_name = document.createElement("INPUT");
	    mom_name.setAttribute("type", "text");
	    mom_name.setAttribute("name", title);
	    mom_name.setAttribute("id", title);

	    var data_title_Td = document.createElement("TD");
	   	data_title_Td.appendChild(mom_name);
	   	data_title_Td.style.color  = "#000";
	   	dataTr.appendChild(data_title_Td);



	   	var responsible = "responsible"+counter;
	    var mom_responsible = document.createElement("textarea");
	    // mom_responsible.setAttribute("type", "text");
	    mom_responsible.setAttribute("name", responsible);
	    mom_responsible.setAttribute("id", responsible);
	    mom_responsible.setAttribute("rows","4");
	    mom_responsible.setAttribute("cols","25");
	    mom_responsible.readOnly = true;
	    mom_responsible.style.fontSize = "medium";


	    var alink = document.createElement("a");
	   	alink.href = "Javascript:testScript('"+responsible+"')";
	   	alink.appendChild(mom_responsible);

	    var responsible_Td = document.createElement("TD");
	   	responsible_Td.appendChild(alink);
	   	responsible_Td.style.color  = "#000";
	   	dataTr.appendChild(responsible_Td);


	    var start_time = "start_time"+ counter;
	    var mom_start_time= document.createElement("INPUT");
	    mom_start_time.setAttribute("type", "text");
	    mom_start_time.setAttribute("name", start_time);
	    mom_start_time.setAttribute("id",start_time);
	    mom_start_time.setAttribute("value",getFormattedDate());
	    mom_start_time.readOnly = true;

		var start_time_icon = "start_time-icon-"+ counter;
	    var calanderIconStart = document.createElement("img");
	    //calanderIcon.innerHTML = '<td align="center"><img id src="/mom/public/js/images/cal.gif" onClick=callNewCssCal(this.id);"></td>';
	    calanderIconStart.setAttribute("src", "/mom/public/js/images/cal.gif");
	    calanderIconStart.setAttribute("alt", "0");
	    calanderIconStart.setAttribute("id",start_time_icon);
	    calanderIconStart.setAttribute("onclick", "callNewCssCal(this.id);" );


	    var start_time_Td = document.createElement("TD");
	   	start_time_Td.appendChild(mom_start_time);
	   	start_time_Td.appendChild(calanderIconStart);
	   	start_time_Td.style.color  = "#000";
	   	dataTr.appendChild(start_time_Td);
	   	//document.getElementById(start_time).readOnly = true;

	    var end_time = "end_time"+ counter;
	    var mom_end_time= document.createElement("INPUT");
	    mom_end_time.setAttribute("type", "text");
	    mom_end_time.setAttribute("name", end_time);
	    mom_end_time.setAttribute("id",end_time);
	    mom_end_time.setAttribute("value",getFormattedDate());
	    mom_end_time.readOnly = true;


	    var end_time_icon = "end_time-icon-"+ counter;
	    var calanderIconEnd = document.createElement("img");
	    //calanderIcon.innerHTML = '<td align="center"><img id src="/mom/public/js/images/cal.gif" onClick=callNewCssCal(this.id);"></td>';
	    calanderIconEnd.setAttribute("src", "/mom/public/js/images/cal.gif");
	    calanderIconEnd.setAttribute("alt", "0");
	    calanderIconEnd.setAttribute("id",end_time_icon);
	    calanderIconEnd.setAttribute("onclick", "callNewCssCal(this.id);" );

	    var end_time_Td = document.createElement("TD");
	   	end_time_Td.appendChild(mom_end_time);
	   	end_time_Td.appendChild(calanderIconEnd);
	   	end_time_Td.style.color  = "#000";
	   	dataTr.appendChild(end_time_Td);
	   	//document.getElementById(end_time).readOnly = true;

	    var statusArr = ["active","closed"];

	    var status = "mom_status"+counter;
	    var mom_status = document.createElement("SELECT");

	    for (var i = 0; i < statusArr.length; i++) 
	    {
		    var option = document.createElement("option");
		    option.value = statusArr[i];
		    option.text = statusArr[i];
		    mom_status.appendChild(option);
		}
	    mom_status.setAttribute("name", status);
	    mom_status.setAttribute("id", status);

	    var status_Td = document.createElement("TD");
	   	status_Td.appendChild(mom_status);
	   	status_Td.style.color  = "#000";
	   	dataTr.appendChild(status_Td);

	   	var completionstatusArr = ["0-50","50-80","80-100"];

	    var completion_status = "mom_completion_status"+counter;
	    var mom_completion_status = document.createElement("SELECT");

	    for (var i = 0; i < completionstatusArr.length; i++) 
	    {
		    var option = document.createElement("option");
		    option.value = completionstatusArr[i];
		    option.text = completionstatusArr[i];
		    mom_completion_status.appendChild(option);
		}
	    mom_completion_status.setAttribute("name", completion_status);
	    mom_completion_status.setAttribute("id", completion_status);

	    var completion_status_Td = document.createElement("TD");
	   	completion_status_Td.appendChild(mom_completion_status);
	   	completion_status_Td.style.color  = "#000";
	   	dataTr.appendChild(completion_status_Td);

	   	var comment = "mom_comment"+counter;
	    var mom_comment = document.createElement("textarea");
	    //mom_comment.setAttribute("type", "textarea");
	    mom_comment.setAttribute("name", comment);
	    mom_comment.setAttribute("id", comment);
	    mom_comment.setAttribute("rows","3");
	    mom_comment.setAttribute("cols","20");
	    //mom_comment.setAttribute("style","auto");
	    

	    var comment_Td = document.createElement("TD");
	   	comment_Td.appendChild(mom_comment);
	   	comment_Td.style.color  = "#000";
	   	dataTr.appendChild(comment_Td);


		var remove_div = document.createElement("img");
	    var remove_div_id = divName + "-"+"remove";
	    //calanderIcon.innerHTML = '<td align="center"><img id src="/mom/public/js/images/cal.gif" onClick=callNewCssCal(this.id);"></td>';
	    remove_div.setAttribute("src", "/mom/public/js/images/cal_close.gif");
	    remove_div.setAttribute("alt", "0");
	    remove_div.setAttribute("id",remove_div_id);
	    remove_div.setAttribute("onclick", "deleteDiv(this.id);" );

	    var remove_Td = document.createElement("TD");
	   	remove_Td.appendChild(remove_div);
	   	remove_Td.style.color  = "#000";
	   	dataTr.appendChild(remove_Td);


	    var mom_count = document.createElement("INPUT");
	    mom_count.setAttribute("type", "hidden");
	    mom_count.setAttribute("name", "count_mom[]");
	    mom_count.setAttribute("id", "count_mom[]");
	    mom_count.setAttribute("value", counter);

	    var count_Td = document.createElement("TD");
	   	count_Td.appendChild(mom_count);
	   	count_Td.style.color  = "#000";
	   	count_Td.style.display = 'none';
	   	dataTr.appendChild(count_Td);




	   	table.appendChild(dataTr);
	    
	    // /dynamicDiv.appendChild(table).fadeIn(1000);
	    $(dynamicDiv).append(table);
	    $(table).fadeIn(1000);
	    //document.getElementById(comment).rows = "3";

	    /***********************/

	   	

	 //   	var title_label = document.createElement('h5');
	 // //   	var label_Title = document.createTextNode('Title');
		// // title_label.appendChild(label_Title);
	 //   	//dynamicDiv.appendChild(title_label);

	 //    var title = "mom_title"+counter;
	 //    var mom_name = document.createElement("INPUT");
	 //    mom_name.setAttribute("type", "text");
	 //    mom_name.setAttribute("name", title);
	 //    mom_name.setAttribute("id", title);
	 //    title_label.appendChild(mom_name);

	 //    //var responsible_label = document.createElement('h5');
	 // //   	var label_responsible = document.createTextNode('Mom Responsible');
		// // title_label.appendChild(label_responsible);
	 //   	//dynamicDiv.appendChild(responsible_label);

	 //    var responsible = "responsible"+counter;
	 //    var mom_responsible = document.createElement("INPUT");
	 //    mom_responsible.setAttribute("type", "text");
	 //    mom_responsible.setAttribute("name", responsible);
	 //    mom_responsible.setAttribute("id", responsible);
	 //    //loadAutoComplete(mom_responsible.id);
	 //    title_label.appendChild(mom_responsible);

	 //   // var start_time_label = document.createElement('h5');
	 // //   	var label_start_time = document.createTextNode('Start Time');
		// // title_label.appendChild(label_start_time);
	 //   	//dynamicDiv.appendChild(start_time_label);

	 //    var start_time = "start_time"+ counter;
	 //    var mom_start_time= document.createElement("INPUT");
	 //    mom_start_time.setAttribute("type", "text");
	 //    mom_start_time.setAttribute("name", start_time);
	 //    mom_start_time.setAttribute("id",start_time);
	 //    title_label.appendChild(mom_start_time);

	 //    var start_time_icon = "start_time-icon-"+ counter;
	 //    var calanderIconStart = document.createElement("img");
	 //    //calanderIcon.innerHTML = '<td align="center"><img id src="/mom/public/js/images/cal.gif" onClick=callNewCssCal(this.id);"></td>';
	 //    calanderIconStart.setAttribute("src", "/mom/public/js/images/cal.gif");
	 //    calanderIconStart.setAttribute("alt", "0");
	 //    calanderIconStart.setAttribute("id",start_time_icon);
	 //    calanderIconStart.setAttribute("onclick", "callNewCssCal(this.id);" );

	 //    title_label.appendChild(calanderIconStart);

	 //   // var end_time_label = document.createElement('h5');
	 // //   	var label_end_time = document.createTextNode('End Time');
		// // title_label.appendChild(label_end_time);
	 //   	//dynamicDiv.appendChild(end_time_label);

	 //    var end_time = "end_time"+ counter;
	 //    var mom_end_time= document.createElement("INPUT");
	 //    mom_end_time.setAttribute("type", "text");
	 //    mom_end_time.setAttribute("name", end_time);
	 //    mom_end_time.setAttribute("id",end_time);
	 //    title_label.appendChild(mom_end_time);

	 //    var end_time_icon = "end_time-icon-"+ counter;
	 //    var calanderIconEnd = document.createElement("img");
	 //    //calanderIcon.innerHTML = '<td align="center"><img id src="/mom/public/js/images/cal.gif" onClick=callNewCssCal(this.id);"></td>';
	 //    calanderIconEnd.setAttribute("src", "/mom/public/js/images/cal.gif");
	 //    calanderIconEnd.setAttribute("alt", "0");
	 //    calanderIconEnd.setAttribute("id",end_time_icon);
	 //    calanderIconEnd.setAttribute("onclick", "callNewCssCal(this.id);" );

	 //    title_label.appendChild(calanderIconEnd);

	 //    //var mom_status_label = document.createElement('h5');
	 // //   	var label_mom_status = document.createTextNode('Status');
		// // title_label.appendChild(label_mom_status);
	 //   	//dynamicDiv.appendChild(mom_status_label);

	 //   	var statusArr = ["active","closed"];

	 //    var status = "mom_status"+counter;
	 //    var mom_status = document.createElement("SELECT");

	 //    for (var i = 0; i < statusArr.length; i++) 
	 //    {
		//     var option = document.createElement("option");
		//     option.value = statusArr[i];
		//     option.text = statusArr[i];
		//     mom_status.appendChild(option);
		// }
	 //    mom_status.setAttribute("name", status);
	 //    mom_status.setAttribute("id", status);
	 //    title_label.appendChild(mom_status);

	 // //    var label_comment = document.createTextNode('Description/Comment');
		// // title_label.appendChild(label_comment);
	 //   	//dynamicDiv.appendChild(responsible_label);

	 //    var comment = "mom_comment"+counter;
	 //    var mom_comment = document.createElement("INPUT");
	 //    mom_comment.setAttribute("type", "textarea");
	 //    mom_comment.setAttribute("name", comment);
	 //    mom_comment.setAttribute("id", comment);
	 //    title_label.appendChild(mom_comment);

	 //    var remove_div = document.createElement("img");
	 //    var remove_div_id = divName + "-"+"remove";
	 //    //calanderIcon.innerHTML = '<td align="center"><img id src="/mom/public/js/images/cal.gif" onClick=callNewCssCal(this.id);"></td>';
	 //    remove_div.setAttribute("src", "/mom/public/js/images/cal_close.gif");
	 //    remove_div.setAttribute("alt", "0");
	 //    remove_div.setAttribute("id",remove_div_id);
	 //    remove_div.setAttribute("onclick", "deleteDiv(this.id);" );
	 //    title_label.appendChild(remove_div);

	 //    var mom_count = document.createElement("INPUT");
	 //    mom_count.setAttribute("type", "hidden");
	 //    mom_count.setAttribute("name", "count_mom[]");
	 //    mom_count.setAttribute("id", "count_mom[]");
	 //    mom_count.setAttribute("value", counter);
	 //    title_label.appendChild(mom_count);

	 //    //formDivName.appendChild(dynamicDiv);
	 //    dynamicDiv.appendChild(title_label);
	    

	    

	    //var mcounts = document.getElementById("count_mom");
		//mcounts.setAttribute("value",counter);
		//dynamicDiv.appendChild(mcounts);
	 //    divIds = document.getElementById("mom_title1");
		// alert(divIds);
		//alert(counter);
		rearrangeID(counter);
	    document.getElementById("formDiv").appendChild(dynamicDiv);
	    //rearrangeID(counter);
	    for(i=1;i<counter+1;i++)
	    {
	    	idRes = "responsible"+i;
	    	//alert(idRes);
	    	loadAutoComplete(idRes);
	    }

	    counter++;
	    var optionValues = [];

		// $('#mail_recipient_index option').each(function() {
		//     optionValues.push($(this).val());
		//     //alert($(this).val());
		// });
  //  		alert(optionValues[0]);
  //   	var recipeint_arr = new Array();
		// $('#mail_recipient_index').find('option').each(function() {
	 //    alert($(this).val());
		// });
		
	   //alert(txt);
   
}
function testScript(id){
	//alert(id);
	 //var clientName = document.getElementById('fault_type').value;
  window.open('responsiblePage?responsibleID='+id,'width=700, height=500, left=250');
  return false;
}
function loadAutoComplete(id)
{
	ID = "#"+id;
	
	var x = document.getElementById("mail_recipient_index[]");
	    var i;
	    for (i = 0; i < x.length; i++) {
	        recipient_arr_src[i] = x.options[i].text;
	    }
	// var recipeint_arr = new Array();
	// $('select#mail_recipient_index[]').find('option').each(function() {
 //    alert($(this).val());
	// });
		
	$(ID).autocomplete({
		source: recipient_arr_src
	});

}
function loadAutoCompleteSource(){
	var x = document.getElementById("mail_recipient_index[]");
	    var i;
	    for (i = 0; i < x.length; i++) {
	        recipient_arr_src[i] = x.options[i].text;
	    }
}

function callNewCssCal(times)
{
	var timeDivide = times.split("-");
	time = timeDivide[0]+timeDivide[2];	
	NewCssCal (time,'yyyyMMdd','dropdown',true,'24',true);
}

function deleteDiv(divId)
{
	var res = divId.split("-");
	dId = document.getElementById(res[0]);
	count_moms = document.getElementById("count_mom");

	//alert(dId);
	document.getElementById("formDiv").removeChild(dId);
	//counter--;
	rearrangeID(counter);

	
	if(counter=='2')
	{
		counter ='1';
	}
	//alert(counter);
	//dynamicDiv.appendChild(mom_count);
	//rearrangeID();

}
function rearrangeID(calling)
{
	
	newID = 1;

	// divIds = document.getElementById("div1").value;
	// alert(divIds);
	for(i=1;i<200;i++){
		divId = document.getElementById('div'+i);
		mom_title = document.getElementById('mom_title'+i);
		responsible = document.getElementById('responsible'+i);
		start_time = document.getElementById('start_time'+i);
		start_time_icon = document.getElementById('start_time-icon-'+i);
		end_time = document.getElementById('end_time'+i);
		end_time_icon = document.getElementById('end_time-icon-'+i);
		mom_status = document.getElementById('mom_status'+i);
		mom_completion_status = document.getElementById('mom_completion_status'+i);
		mom_label = document.getElementById('mom_label'+i);
		mom_comment = document.getElementById('mom_comment'+i);
		re_id = "div"+i+"-remove";
		removeId = document.getElementById(re_id);
		mcounts = document.getElementById('count_mom[]');

					
		
		if (mom_title) {
			divId.setAttribute('id','div'+newID);
			
			mom_title.setAttribute('id','mom_title'+newID);
			mom_title.setAttribute('name','mom_title'+newID);
			
			responsible.setAttribute('id','responsible'+newID);

			var idRes = "responsible"+newID;
	    	loadAutoComplete(idRes);

			responsible.setAttribute('name','responsible'+newID);
			start_time.setAttribute('id','start_time'+newID);
			start_time.setAttribute('name','start_time'+newID);
			start_time_icon.setAttribute('id','start_time-icon-'+newID);
			end_time.setAttribute('id','end_time'+newID);
			end_time.setAttribute('name','end_time'+newID);
			end_time_icon.setAttribute('id','end_time-icon-'+newID);
			mom_status.setAttribute('id','mom_status'+newID);
			mom_status.setAttribute('name','mom_status'+newID);
			mom_completion_status.setAttribute('id','mom_completion_status'+newID);
			mom_completion_status.setAttribute('name','mom_completion_status'+newID);
			mom_comment.setAttribute('id','mom_comment'+newID);
			mom_comment.setAttribute('name','mom_comment'+newID);
			
			mom_label.setAttribute('id','mom_label'+newID);
			mom_label.innerText = "Action Point - "+newID;
			r_id = "div"+newID+"-remove";
			removeId.setAttribute('id',r_id);

			// read_start_time = 'start_time'+newID;
			// //alert(read_start_time);
			// read_end_time = 'end_time'+newID;
			// document.getElementById(read_start_time).readOnly = true;
			// document.getElementById(read_end_time).readOnly = true;

			// start_time.readOnly = true;
			// end_time.readOnly = true;
			//alert(divId+"new id"+newID);
			//mcounts.setAttribute('value',newID-1);
			
			

			newID++;
			mcounts.value = newID;
			counter = newID;
			
			//alert(counter);
		}


	}
	//alert(divId);

}

function copyMom(mom_count)
{ //on add input button click
        createMom();
		var j = mom_count;

		mom_title_prev = document.getElementById('mom_title_prev'+j).value;
		responsible_prev = document.getElementById('responsible_prev'+j).value;
		start_time_prev = document.getElementById('start_time_prev'+j).value;
		end_time_prev = document.getElementById('end_time_prev'+j).value;
		mom_status_prev = document.getElementById('mom_status_prev'+j).value;
		mom_completion_status_prev = document.getElementById('mom_completion_status_prev'+j).value;
		mom_comment_prev = document.getElementById('mom_comment_prev'+j).value;

		
		//alert(mom_comment_prev);

		for(i=1;i<20;i++)
		{
			mom_title = document.getElementById('mom_title'+i);
			responsible = document.getElementById('responsible'+i);
			start_time = document.getElementById('start_time'+i);
			end_time = document.getElementById('end_time'+i);
			mom_status = document.getElementById('mom_status'+i);
			mom_completion_status = document.getElementById('mom_completion_status'+i);
			mom_comment = document.getElementById('mom_comment'+i);
			
			if (mom_title) 
			{
				if(!mom_title.value.match(/\S/))
				{

					mom_title.setAttribute('value',mom_title_prev);
					responsible.value = responsible_prev;
					start_time.setAttribute('value',start_time_prev);
					end_time.setAttribute('value',end_time_prev);
					mom_status.setAttribute('value',mom_status_prev);
					mom_completion_status.setAttribute('value',mom_completion_status_prev);
					mom_comment.value = mom_comment_prev;

				
				}
				//alert(divId+"new id"+newID);
				//mcounts.setAttribute('value',newID-1);
				
				//alert(counter);
			}
		}

	
		
}

function addAttendee()
{ //on add input button click
        
		meeting_attendee_select_value = document.getElementById('meeting_attendee_select').value;
		meeting_attendee_select_id = document.getElementById('meeting_attendee_select');
		var splitResult = meeting_attendee_select_value.split("|");
		var splittedDept = splitResult[1].split("(");
		
		// meeting_attendee= document.getElementById('meeting_attendee');
		// meeting_attendee_value= document.getElementById('meeting_attendee').value;

		// // mail_recipient= document.getElementById('mail_recipient');
		// // mail_recipient_value= document.getElementById('mail_recipient').value;

		// if(meeting_attendee_value=='')
		// {
		// 	setAttendee = meeting_attendee_select_value;	
		// }
		// else
		// {
		// 	setAttendee = meeting_attendee_value+","+meeting_attendee_select_value;
		// }
		// // if(mail_recipient_value=='')
		// // {
		// // 	setRecipient = meeting_attendee_select_value;	
		// // }
		// // else
		// // {
		// // 	setRecipient = mail_recipient_value+","+meeting_attendee_select_value;
		// // }
			
		// meeting_attendee.setAttribute('value',setAttendee);

		//mail_recipient.setAttribute('value',setRecipient);
		//meeting_attendee_select_id.setAttribute('value','');
		//alert(mom_title_prev);
		isRecipientExists = false;
		isRecipientNull = true;
		isAttendeeExists = false;
		isAttendeeNull = true;
		//var splittedDept = Array();

		var meeting_attendee_index = document.getElementById( "meeting_attendee_index[]" );
		//$(meeting_attendee_index).append('<option value="'+meeting_attendee_select_value+'">'+meeting_attendee_select_value+'</option>')
		
		for (var i = 0; i < meeting_attendee_index.options.length; i++) 
	    { 
	        if(meeting_attendee_index.options[i].value == splitResult[0])
	        {
	        	isAttendeeExists = true;
	        }
	        if(splitResult[0] == '')
	        {
	        	isAttendeeNull = true;
	        	isAttendeeExists = true;
	        }

	    }
	    if(isAttendeeExists == false)
	    {
	    	//var splitResult = meeting_attendee_select_value.split(",");
	    	$(meeting_attendee_index).append('<option value="'+splitResult[0]+'">'+splitResult[0]+'</option>')
	    }
	    // else
	    // {
	    // 	if(isAttendeeNull == true)
	    // 	{
	    // 		//alert('Select attendee field null');
	    // 	}
	    // 	else
	    // 	{
	    // 		//alert("Attendee already added");
	    // 	}
	    	
	    // }

		var mail_recipient_index = document.getElementById( "mail_recipient_index[]" );
		
		for (var i = 0; i < mail_recipient_index.options.length; i++) 
	    { 
	        if(mail_recipient_index.options[i].value == splitResult[0])
	        {
	        	isRecipientExists = true;
	        } 
	        // if(meeting_attendee_select_valuee == '')
	        // {
	        // 	isRecipientNull = true;
	        // 	isRecipientExists = true;
	        // }
	    }
	    if(isAttendeeExists == false)
	    {
	    	
	    	$(mail_recipient_index).append('<option value="'+splitResult[0]+'">'+splitResult[0]+'</option>')
	    }
	    
	    isDeptExists = false;
		var attendee_dept_index = document.getElementById( "attendee_dept_index[]" );

		for (var i = 0; i < attendee_dept_index.options.length; i++) 
	    { 
	    	//var splitResult = meeting_attendee_select_value.split(",");
	    	
	        if(attendee_dept_index.options[i].value == splittedDept[0])
	        {
	        	isDeptExists = true;
	        } 
	        if(splittedDept[0] == '')
	        {
	        	isDeptExists = true;
	        } 
	    }
	    if(isDeptExists == true)
	    {
	    	//alert("Dept already added");
	    }
	    if(isDeptExists == false)
	    {
	    	//var splitResult = meeting_attendee_select_value.split(",");
	    	//var splitResultPost = splitResult[1].split('(');
	    	if(splittedDept.length >1){
	    		$(attendee_dept_index).append('<option value="'+splittedDept[0]+'">'+splittedDept[0]+'</option>')
	    	}
	    	
	    }

		//$(mail_recipient_index).append('<option value="'+meeting_attendee_select_value+'">'+meeting_attendee_select_value+'</option>')
		meeting_attendee_select_id.value = '';
		loadAutoCompleteSource();
}
function deleteAttendee()
{
	var meeting_attendee_index = document.getElementById( "meeting_attendee_index[]" );
	meeting_attendee_index.remove(meeting_attendee_index.selectedIndex);
	loadAutoCompleteSource();
}
function deleteRecipient()
{
	

	var mail_recipient_index = document.getElementById( "mail_recipient_index[]" );
	mail_recipient_index.remove(mail_recipient_index.selectedIndex);
	loadAutoCompleteSource();
}
function deleteDept()
{
	var attendee_dept_index = document.getElementById( "attendee_dept_index[]" );
	attendee_dept_index.remove(attendee_dept_index.selectedIndex);
	loadAutoCompleteSource();
}
function addDept(){
	isExists = false;
	attendee_dept_select_value = document.getElementById('attendee_dept_select').value;
	attendee_dept_select_id = document.getElementById('attendee_dept_select');
	var attendee_dept_index = document.getElementById( "attendee_dept_index[]" );

	for (var i = 0; i < attendee_dept_index.options.length; i++) 
    { 
        if(attendee_dept_index.options[i].value == attendee_dept_select_value)
        {
        	isExists = true;
        } 
        if(attendee_dept_select_value == '')
        {
        	isExists = true;
        } 
    }
    if(isExists == true)
    {
    	alert("Dept already added");
    }
    else
    {
    	var splitResultWithPost = meeting_attendee_select_value.split("|");
    	var splitRestultDeptArr = splitResultWithPost.split("(");
    	var splitResult = splitRestultDeptArr[0];

    	$(attendee_dept_index).append('<option value="'+splitResult+'">'+splitResult+'</option>')
    }
	attendee_dept_select_id.value = '';
	loadAutoCompleteSource();
}
function addRecipient()
{
	isExists = false;
	mail_recipient_select_value = document.getElementById('mail_recipient_select').value;
	mail_recipient_select_id = document.getElementById('mail_recipient_select');
	var mail_recipient_index = document.getElementById( "mail_recipient_index[]" );
	var splitResult = mail_recipient_select_value.split("|");

	for (var i = 0; i < mail_recipient_index.options.length; i++) 
    { 
        if(mail_recipient_index.options[i].value == splitResult[0])
        {
        	isExists = true;
        } 
        if(mail_recipient_select_value == '')
        {
        	isExists = true;
        } 
    }
    if(isExists == true)
    {
    	alert("Recipient already added");
    }
    else
    {
    	$(mail_recipient_index).append('<option value="'+splitResult[0]+'">'+splitResult[0]+'</option>')
    }
	mail_recipient_select_id.value = '';
	loadAutoCompleteSource();
}
function validateMom()
{
	var txt;
	var r = confirm("Are you sure??");
	var msg ='Please below fields:\n';
	if (r == true) {
		var isValid = true;
		var isMailRecipient = false;
		var isMomResponsible = false;
		var isMeetingTitle = false;
		var isMeetingDatetime= false;
		var meeting_title= null;
		var meeting_datetime= null;
		var isMeetingAttendee = false;
		var isMailRecipient = false;
		var isMomTitle = false;
		//mail_recipient_values= document.getElementById('mail_recipient').value;

		selectBoxAttendee = document.getElementById("meeting_attendee_index[]");
		selectTest = document.getElementById("attendee_dept_index[]");
		// alert(JSON.stringify(selectTest));

		if(selectBoxAttendee.options.length == 0)
		{
			isValid = false;
			isMeetingAttendee = true;
			msg +=  "Blank Meeting Attendee\n";
			//alert("Blank Meeting Attendee");
		}
		for (var i = 0; i < selectTest.options.length; i++) 
	    { 
	        selectTest.options[i].selected = true; 
	    }

	    for (var i = 0; i < selectBoxAttendee.options.length; i++) 
	    { 
	        selectBoxAttendee.options[i].selected = true; 
	    }
		selectBox = document.getElementById("mail_recipient_index[]");
		if(selectBox.options.length == 0)
		{
			isValid = false;
			isMailRecipient = true;
			msg +="Blank Mail Recipient\n";
		}

	    for (var i = 0; i < selectBox.options.length; i++) 
	    { 
	        selectBox.options[i].selected = true; 
	    } 

		var temp = new Array();
		//var temp = mail_recipient_values.split(',');
	    var filter = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

	    for(var i=0;i<selectBox.length;i++)
	    {
	    	var tempValue = selectBox.options[i].value.trim();
		    if (!filter.test(tempValue)) 
		    {
		    	//isValid = false;
		    	//isMailRecipient = true;
		    	//msg +="Invalid email address given in Mail Recipient Field\n";
		    }
		}
		for(var j=1;j<50;j++)
		{
			res = 'responsible'+j;
			title = 'mom_title'+j;
			try
			{
				responsible_values = document.getElementById(res).value;
				title_values = document.getElementById(title);
				if(title_values.value == '')
				{
					isMomTitle = true;
					isValid = false;
					msg +="Blank MoM Title\n";
				}
			}
			catch(err)
			{
				break;
			}
			var temp_responsible = new Array();
			var temp_responsible = responsible_values.split(',');
			//alert(JSON.stringify(temp_responsible));
			// alert(responsible_values);
			if(temp_responsible.length == 0)
			{
				isValid = false;
			}
			if(temp_responsible[1] != null)
			{
				for(var k=0;k<temp_responsible.length;k++)
				{
					var temp_responsible_arr = temp_responsible[k].split('|');
					if (!filter.test(temp_responsible_arr[0])) 
				    {
				    	isValid = false;
				    	isMomResponsible = true;
				    	msg +="Invalid email address given in MoM Responsible Field\n";
				    }
				}
			}
			else
			{
				var temp_responsible_arr = temp_responsible[0].split('|');
				if (!filter.test(temp_responsible_arr[0])) 
				{
				    isValid = false;
				    isMomResponsible = true;
				    msg +="Invalid email address given in MoM Responsible Field\n";
				}
			}
		}
		try
		{
			meeting_title= document.getElementById('meeting_title').value;
			meeting_datetime= document.getElementById('meeting_datetime').value;
			if(meeting_title == ''){
				msg +="Blank Meeting Title\n";
				// alert(msg);
				isMeetingTitle = true;
				isValid = true;
			}
			if(meeting_datetime == ''){
				msg +="Blank Meeting Datetime\n";
				isMeetingDatetime = true;
				isValid = false;
			}
		}
		catch(err)
		{
			// if(meeting_title == '')
			// {
				msg +="Blank Meeting Title\n";
				//isValid = false;
				isMeetingTitle = true;
			// }
			// if(meeting_datetime == '')
			// {
				msg +="Blank Meeting Datetime\n";
				isMeetingDatetime = true;
			// }
		}
		// var filess = document.getElementById('meeting_files[]');
		// alert(files.length);
		// if(files.length > 3)
		// {
		// 	alert("Files count is more then 3");
		// 	isValid=false;
		// }
		var fileUpload = $("input[type='file']");
		if(fileUpload)
		{
			//alert(fileUpload[0].name);
			//alert(fileUpload[0].files[0].name);
		    if (parseInt(fileUpload.get(0).files.length)>3)
		    {
		         msg += "\nYou can only upload a maximum of 3 files";
		         isValid=false;
		    }
		    else{
		    	var loopCount = parseInt(fileUpload.get(0).files.length);
		    	//alert(loopCount);
		    	for(var i=0;i<loopCount;i++){
		    		var tempFileName = fileUpload[0].files[i].name;
		    		var tempFileNameArr = tempFileName.split('.');
		    		var tempFileNameArrLength = tempFileNameArr.length;
		    		var extensionName = tempFileNameArr[tempFileNameArrLength - 1];
		    		if(extensionName == 'ppt' || extensionName == 'xls' || extensionName == 'doc' || extensionName == 'docx' || extensionName == 'txt' || extensionName == 'csv' || extensionName == 'pptx' || extensionName == 'pdf'|| extensionName == 'xlsx'|| extensionName == 'xlsm'){

		    		}
		    		else{
		    			msg += "\nSuggested File extension : ppt,pptx,xls,xlsx,xlsm,csv,doc,docx,txt";
		    			isValid=false;
		    		}
		    	}

		    }
		    
		}
		var meeting_schedule_type_value = document.getElementById('meeting_schedule_type').value;
		//alert(meeting_schedule_type_value);
		var option_length = document.getElementById('attendee_dept_index[]').length;
		//alert(option_length);
		if(meeting_schedule_type_value != 'AD-HOC' ){
			if(option_length > 1){
				msg = "\n Please select only one attendee dept if you want to make Meeting Schedule type ";
				msg += meeting_schedule_type_value;
				isValid=true;
			}
		}
		// bootbox.confirm("Are you sure?", function(result) {
		//   Example.show("Confirm result: "+result);
		// });
		//alert(isValid);
	    if(isValid == true)
	    {
	    	exitValue = null;
	    	document.getElementById("meetingForm").submit();

	    }
	    else
	    {
	    	//document.getElementById("meetingForm").submit();
	    	alert(msg);
	    	// if(isMailRecipient == true)
	    	// {
	    	// 	alert("Invalid email address given in Mail Recipient Field");
	    	// }
	    	// if(isMomResponsible == true)
	    	// {
	    	// 	alert("Invalid email address given in MoM Responsible Field");
	    	// }
	    	// if(isMeetingTitle == true)
	    	// {
	    	// 	alert("Blank Meeting Title");
	    	// }
	    	// if(isMeetingDatetime == true)
	    	// {
	    	// 	alert("Blank Meeting Datetime");
	    	// }
	    	// if(isMeetingAttendee == true)
	    	// {
	    	// 	alert("Blank Meeting Attendee");
	    	// }
	    	// if(isMailRecipient == true)
	    	// {
	    	// 	alert("Blank Mail Recipient");
	    	// }
	    	// if(isMomTitle == true)
	    	// {
	    	// 	alert("Blank MoM Title");
	    	// }

			
	    }
	    
	} else {
	    
	}
	
	//alert(temp[0]);
	//document.getElementById("meetingForm").submit();
}

function validateMomCreate()
{

	var isValid = true;
	var isMailRecipient = false;
	var isMomResponsible = false;
	mail_recipient_values= document.getElementById('mail_recipient').value;
	var temp = new Array();
	var temp = mail_recipient_values.split(',');
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    for(var i=0;i<temp.length;i++)
    {
	    if (!filter.test(temp[i])) 
	    {
	    	isValid = false;
	    	isMailRecipient = true;
	    }
	}
	for(var j=1;j<50;j++)
	{
		res = 'responsible'+j;
		try
		{
			responsible_values = document.getElementById(res).value;
		}
		catch(err)
		{
			break;
		}
		var temp_responsible = new Array();
		var temp_responsible = responsible_values.split(',');
		// alert(responsible_values);
		if(temp_responsible[1] != null)
		{
			for(var k=0;k<temp_responsible.length;k++)
			{
				if (!filter.test(temp_responsible[k])) 
			    {
			    	isValid = false;
			    	isMomResponsible = true;
			    }
			}
		}
		else
		{
			if (!filter.test(temp_responsible)) 
			{
			    isValid = false;
			    isMomResponsible = true;
			}
		}
	}


	meeting_title = document.getElementById('meeting_title').value;
	meeting_datetime = document.getElementById('meeting_datetime').value;

	
    if(isValid == true)
    {
    	document.getElementById("meetingForm").submit();
    }
    else
    {
    	if(isMailRecipient == true)
    	{
    		alert("Invalid email address given in Mail Recipient Field");
    	}
    	if(isMomResponsible == true)
    	{
    		alert("Invalid email address given in MoM Responsible Field");
    	}
		
    }

	//alert(temp[0]);
	//document.getElementById("meetingForm").submit();
}
// function pdfTest(){
// 	$(function () {

//     var specialElementHandlers = {
//         '#editor': function (element,renderer) {
//             return true;
//         }
//     };
// 	 var doc = new jsPDF();
//         doc.fromHTML($('#body_id').html(), 15, 15, {
//             'width': 170,'elementHandlers': specialElementHandlers
//         });
//         doc.save('sample-file.pdf');
//     }); 
// }



