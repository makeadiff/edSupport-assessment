$(document).ready(function(){

  //Working Script ----- alert('Hi');
  
  $('#select-center').change(function(e){
    var centerId = selectClass.centerId.value;
    var year = selectClass.year.value;
    e.preventDefault();
    
    $.post('fetchYear',{centerId: centerId,year: year},function(data){
    	console.log(data);
	var obj = JSON.parse(data);
	var string="";
	var string2="";
// 	for(i=0;i<obj.year.length;i++){
// 	  string += '<option value="'+ obj.year[i].year+'">'+obj.year[i].year+'-'+(Number(obj.year[i].year)+1)+'</option>';
// 	}
// 	$('#select-year').html(string);
	for(i=0;i<obj.class.length;i++){  
	  string2 += '<option value="'+ obj.class[i].id+'">'+obj.class[i].name+'</option>'; 
	}
	$('#classSelected').html(string2);
	console.log(string);
    });
  });

//   $('#select-year').change(function(e){
//     var year = selectClass.year.value;
//     var centerId = selectClass.centerId.value;
//     e.preventDefault();
//     
//     $.post('fetchLevel',{centerId: centerId, year: year},function(data){
// // 	console.log(data);
// 	var obj = JSON.parse(data);
// 	var string="";
// 	for(i=0;i<obj.length;i++){
// 	  string += '<option value="'+obj[i].id+'">'+obj[i].name+'</option>';
// 	}
// 	$('#classSelected').html(string);
// // 	console.log(string);    
//     });
    
    
//   });
   
    
});


function ValidateMarkForm(){
    if(total>100){
      alert('Total Marks should not be greater than 100');
    }
    var subjects = 3;
    var length = $('.markInput').length;   
    for (var i=0;i<length-1;i+=2){
  	var markValue = parseInt(document.getElementsByClassName('markInput').item(i).value);	
	var total = parseInt(document.getElementsByClassName('markInput').item(i+1).value);
// 	alert(total);
//     	return false;
    
	if(markValue>total){
	  //Obtained Marks Cannot be Greater than Total Marks
	  alert('Marks Obtained cannot be grater than to Total Marks Allocated');
	  return false;
	}
    }
    return true;
}

  
