$(document).ready(function(){

  //Working Script ----- alert('Hi');
  
  var height = $(window).height();
  $('.blue-red').css({
    minHeight:height    
  });
  
  $('.total-all').change(function(){
     var total = this.value;
//      alert(total);
     var totalClass = document.getElementsByClassName('total');
     for(var i=0;i < totalClass.length; i++){
	totalClass[i].setAttribute("value",total);
     }
  });
  
  $('#select-center').change(function(e){
    var centerId = selectClass.centerId.value;
    var year = selectClass.year.value;
    e.preventDefault();
    
    $.post('fetchYear',{centerId: centerId,year: year},function(data){
	console.log(data);
	var obj = JSON.parse(data);
	var string="";
	var string2="";
	for(i=0;i<obj.class.length;i++){  
	  string2 += '<option value="'+ obj.class[i].id+'">'+obj.class[i].name+'</option>'; 
	}
	$('#classSelected').html(string2);
	console.log(string);
    });
  });
  
  $('#select-city').change(function(e){
    var cityId = getReport.cityId.value;
    e.preventDefault();
      
    $.post('fetchListOfCentres',{cityId: cityId},function(data){
      var obj = JSON.parse(data);
      console.log(data);
      var string1="";
      var string2="";
      for(i=0;i<obj.center.length;i++){
	string1 += '<option value="'+obj.center[i].id+'">'+obj.center[i].name+'</option>';	
      }
      $('#select-center-report').html(string1);
      for(i=0;i<obj.classList.length;i++){
	string2 += '<option value="'+obj.classList[i].id+'">'+obj.classList[i].name+'</option>';	
      }
      $('#select-class-list').html(string2);
    });
  });
  
  $('#select-center-report').change(function(e){
    var centerId = getReport.centerId.value;
    e.preventDefault();
    
    $.post('fetchYear',{centerId: centerId},function(data){
      console.log(data);
      var obj = JSON.parse(data);
      var string2="";
      for(i=0;i<obj.class.length;i++){  
	string2 += '<option value="'+ obj.class[i].id+'">'+obj.class[i].name+'</option>'; 
      }
      $('#select-class-list').html(string2);
    });
  });
   
});


function ValidateMarkForm(){
//     if(total>100){
//       alert('Total Marks should not be greater than 100');
//     }
    var subjects = 3;
    var length = $('.markInput').length;   
    for (var i=1;i<length-1;i+=2){
	var markValue = parseInt(document.getElementsByClassName('markInput').item(i).value);	
	//var total = parseInt(document.getElementsByClassName('markInput').item(i+1).value);
	var marks = document.getElementsByClassName('markInput').item(i).value;
	
	/*if(!isNaN(markValue)){
	  if(markValue > total){
	    alert("Marks cannot be greater than total value");
	    return false;
	  }
	}
	else{*/
	  if(marks == "AB" ||marks == "ab" || marks == "NA" || marks == "na" || marks == "OT" || marks == "ot" || (marks >= 0 && marks <=100)){
	  }
	  else{
	    alert("Enter Marks or values from the Legend");
	    return false;
	  }
	//}

    //}
    return true;
}
  
