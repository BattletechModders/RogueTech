function setReputation(arg_faction,arg_button){
	var uval = arg_button.parent().parent().find(".repvalue").val();
	var data = {};
	data.faction = arg_faction
	data.reputation = parseInt(uval);
	$.ajax({
	  dataType: "json",
	  data: JSON.stringify(data),
	  method: "POST",
	  url: "/setreputation",
	  success: function (data){
		  $("#reputationPlace").html("");
		  if(data.hasOwnProperty("error")){
			$("#reputationPlace").html(data.error);
		  }else{
			$("#reputationPlace").html("<table border='1'></table>");
  		    $.each( data, function( key, val ) {
			  $("#reputationPlace").children("table").append("<tr><td>"+key+"</td><td><input class='repvalue' type='text' value='"+val+"'/></td>"+
			       "<td><button type='button' onclick=\"setReputation('"+key+"',$(this))\">Set Reputation</button></td></tr>");
		    }); 		  
		  }
	  }
	});
}

function updateReputation(){
	$.ajax({
	  dataType: "json",
	  url: "/getreputation",
	  success: function (data){
		  $("#reputationPlace").html("");
		  if(data.hasOwnProperty("error")){
			$("#reputationPlace").html(data.error);
		  }else{
			$("#reputationPlace").html("<table border='1'></table>");
  		    $.each( data, function( key, val ) {
			  $("#reputationPlace").children("table").append("<tr><td>"+key+"</td><td><input class='repvalue' type='text' value='"+val+"'/></td>"+
			       "<td><button type='button' onclick=\"setReputation('"+key+"',$(this))\">Set Reputation</button></td></tr>");
		    }); 		  
		  }
	  }
	});
}

function updateItemsList(){
	$.ajax({
	  dataType: "json",
	  url: "/listitems",
	  success: function (data){
		  $("#itemsPlace").html("");
		  if(data.hasOwnProperty("error")){
			$("#itemsPlace").html(data.error);
		  }else{
			$("#itemsPlace").html("<select/>");
  		    $.each( data, function( index, val ) {
			  $("#itemsPlace").children("select").append("<option price='"+val.price+"' type='"+val.type+"' itmname='"+val.name+"'>"+val.name+"</option>");
		    }); 
			$("#itemsPlace").append("<input type='text' value='1'/>");
			$("#itemsPlace").append("<button type='button' onclick='addItem();'>Add Item</button>");
		  }
	  }
	});
}

function addItem(){
	var data = {};
	data.name = $("#itemsPlace").children("select").children("option:selected").attr("itmname")
	data.type = $("#itemsPlace").children("select").children("option:selected").attr("type")
	data.price = $("#itemsPlace").children("select").children("option:selected").attr("price")
	data.count = $("#itemsPlace").children("input").val()
	$.ajax({
	  dataType: "json",
	  data: JSON.stringify(data),
	  method: "POST",
	  url: "/additem",
	  success: function (data){
		  if(data.hasOwnProperty("error")){
			alert(data.error);
		  }else{
			alert("Success");
		  }
	  }
	});
}

function endContract(){
	var data = {};
	$.ajax({
	  dataType: "json",
	  data: JSON.stringify(data),
	  method: "POST",
	  url: "/endcontract",
	  success: function (data){
		  if(data.hasOwnProperty("error")){
			alert(data.error);
		  }else{
			alert("Success");
		  }
	  }
	});
}

$( document ).ready(function() {
	updateReputation();
});