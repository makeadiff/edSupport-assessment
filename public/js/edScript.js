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
	for(i=0;i<obj.length;i++){
	  string += '<option value="'+obj[i].year+'">'+obj[i].year+'-'+(Number(obj[i].year)+1)+'</option>';
	}
	$('#select-year').html(string);
// 	console.log(string);
    });
  });

  $('#select-year').change(function(e){
    var year = selectClass.year.value;
    var centerId = selectClass.centerId.value;
    e.preventDefault();
    
    $.post('fetchLevel',{centerId: centerId, year: year},function(data){
// 	console.log(data);
	var obj = JSON.parse(data);
	var string="";
	for(i=0;i<obj.length;i++){
	  string += '<option value="'+obj[i].id+'">'+obj[i].name+'</option>';
	}
	$('#classSelected').html(string);
// 	console.log(string);    
    });
    
    
  });
  
  
});
