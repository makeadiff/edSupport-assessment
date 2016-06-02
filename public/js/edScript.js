/*

******************* This code is scripted by Rohit Nair.

*/

var count;

$(document).ready(function(){

  var window_width = $(window).width();
  var container_width = $('.container').width();
  $('#fixed-top-div').css({
    width: container_width,
    left: (window_width/2) - (container_width/2) + 12,
  });

  $(window).resize(function(){
    var window_width = $(window).width();
    var container_width = $('.container').width();
    $('#fixed-top-div').css({
      width: container_width,
      left: (window_width/2) - (container_width/2) + 12,
    });
  });

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
  
  /****************************************************************************************************************************/

  //ONLOAD FUNCTION

  $(window).load(function(){
    var length = $('.gradeSelect').length;
    for (var i=0;i<length;i++){
      var template = 'template'+i;
      getGrades(template);
    }    

  });

  $("a").on('click', function(event) {
    var location = window.location;

    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top - 180
      }, 200, function(){
   
        // Add hash (#) to URL when done scrolling (default click behavior)
      });
    } // End if
  });

  $('form').change(function(e){
    //alert(this.value);
    var data = $('#updateScores').serialize();
    document.getElementById('updateSuccess').innerHTML = '<br/><div class="progress"><div class="indeterminate"></div></div>';
    var base_url = window.location;
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: base_url + "/update",
      data: data,
      success: function(data){
        document.getElementById('updateSuccess').innerHTML = '<br/><div class="chip">'+data+'<i class="material-icons">close</i></div>';
      }
    });
  });

  $('form').submit(function(e){
    //return false;
  }); 

  $('.masterSelect').change(function(e) {
    var id = this.id;
    
    $('.'+id).val(this.value);

    var classname = '.'+id;
    var length = $(classname).length;
    var data = this.value;
    //value = this.value;

    var base_url = window.location;
    if(this.value>=0){
      var base_url = window.location;
      e.preventDefault();
      $.ajax({
        type: "POST",
        url: base_url + "/fetchTemplate/"+this  .value,
        data: data,
        success: function(data){

          var parsed = JSON.parse(data);
          var grade_options = '<option value="0" selected>Not Available</option>';

          for (i=0;i<parsed.grade.length;i++){
            grade_options += '<option value"'+parsed.grade[i].grade+'">'+parsed.grade[i].grade+'</option>';
          }

          for(i=0;i<length;i++){
            var element = $(classname)[i];
            template_id = element.id;
            var temp_count = template_id.substring(8,10);
            var value = document.getElementById(template_id).value;

            
            $('#engScore'+temp_count).replaceWith('<select class="markInput secured " id="engScore'+temp_count+'" name="engScore'+temp_count+'"></select>');
            $('#mathScore'+temp_count).replaceWith('<select class="markInput secured " id="mathScore'+temp_count+'" name="mathScore'+temp_count+'"></select>');
            $('#sciScore'+temp_count).replaceWith('<select class="markInput secured " id="sciScore'+temp_count+'" name="sciScore'+temp_count+'"></select>');

            $('#engScore'+temp_count).html(grade_options);
            $('#mathScore'+temp_count).html(grade_options);
            $('#sciScore'+temp_count).html(grade_options);

            if(value==-1){
              $('#totalEng'+temp_count).show();
              $('#totalMath'+temp_count).show();
              $('#totalSci'+temp_count).show();
              $('.total'+temp_count).show();
            }
            else{
              $('#totalEng'+temp_count).hide();
              $('#totalMath'+temp_count).hide();
              $('#totalSci'+temp_count).hide(); 
              $('.total'+temp_count).hide();
            }
          }
        }
      });
    }
    else if(this.value==-1 || this.value==-2){
      for(i=0;i<length;i++){
        var element = $(classname)[i];
        template_id = element.id;
        var temp_count = template_id.substring(8,10);
        var value = document.getElementById(template_id).value;

        $('#engScore'+temp_count).replaceWith('<input class="markInput secured" id="engScore'+temp_count+'" name="engScore'+temp_count+'" value=""/>');
        $('#mathScore'+temp_count).replaceWith('<input class="markInput secured" id="mathScore'+temp_count+'" name="mathScore'+temp_count+'" value=""/>');
        $('#sciScore'+temp_count).replaceWith('<input class="markInput secured" id="sciScore'+temp_count+'" name="sciScore'+temp_count+'" value=""/>');

        if(value==-1){
          $('#totalEng'+temp_count).show();
          $('#totalMath'+temp_count).show();
          $('#totalSci'+temp_count).show();
          $('.total'+temp_count).show();
        }
        else{
          $('#totalEng'+temp_count).hide();
          $('#totalMath'+temp_count).hide();
          $('#totalSci'+temp_count).hide(); 
          $('.total'+temp_count).hide();
        }
      }
    }
  });

  $('.studentGrade').change(function(e){
    var id = this.id;
    
    getGrades(id);

  });


  $('#addMoreRows').click(function(e){
    var count = document.getElementById('count').value;
    var string = '<td><input type="number" name="lower'+count+'" value="" placeholder="90" min="0" required></td><td><input type="number" name="upper'+count+'" value="" placeholder="100" min="0" required></td><td><input type="text" name="grade'+count+'" maxlength="2" required></td>';

    //var tableBody = document.getElementById('tableBody');
    //tableBody.innerHTML += string;
    var table = document.getElementById('gradeTable');
    var row = table.insertRow(-1);
    row.className = 'content';
    row.innerHTML = string;
    e.preventDefault;
    count++;
    document.getElementById('count').value=count;
  });

  $('#removeRows').click(function(e){
    var count = document.getElementById('count').value;
    var string = '<td><input type="number" name="lower'+count+'" value="" placeholder="90" min="0" required></td><td><input type="number" name="upper'+count+'" value="" placeholder="100" min="0" required></td><td><input type="text" name="grade'+count+'" maxlength="2" required></td>';

    //var tableBody = document.getElementById('tableBody');
    //tableBody.innerHTML += string;

    var table = document.getElementById('gradeTable');
    var row = table.deleteRow(-1);
    e.preventDefault;
    count--;
    document.getElementById('count').value=count;
  });

  

});
  
  
function concat(){
  var centerName = document.getElementById('centerName').value;
  var boardName = document.getElementById('boardName').value;
  var gradeName = document.getElementById('gradeName').value;

  var concat = centerName+' '+boardName+' '+gradeName;
  document.getElementById('gradeNameConcated').value = concat;
}

function getGrades(template){
  var temp_count = template.substring(8,10);
  var value = document.getElementById(template).value;
  
  var data = value;

  if(value==-1){
    $('#totalEng'+temp_count).show();
    $('#totalMath'+temp_count).show();
    $('#totalSci'+temp_count).show();
    $('.total'+temp_count).show();
  }
  else{
    $('#totalEng'+temp_count).hide();
    $('#totalMath'+temp_count).hide();
    $('#totalSci'+temp_count).hide(); 
    $('.total'+temp_count).hide();
  }

  //AJAX Script to fetch the Grade Template for the Database.
  if(value>=0){
    var base_url = window.location;
    $.ajax({
      type: "POST",
      url: base_url + "/fetchTemplate/"+value,
      data: data,
      success: function(data){

        var parsed = JSON.parse(data);
        var grade_options = '<option value="0" selected>Not Available</option>';

        for (i=0;i<parsed.grade.length;i++){
          grade_options += '<option value="'+parsed.grade[i].grade+'">'+parsed.grade[i].grade+'</option>';
        }

        engScore = document.getElementById('engScore'+temp_count).value;
        sciScore = document.getElementById('sciScore'+temp_count).value;
        mathScore = document.getElementById('mathScore'+temp_count).value;
        
        if(engScore!="" || mathScore!="" || sciScore!=""){
          var confirm = window.confirm('This will clear the exisiting data. Press OK to continue');
          alert(confirm);
        }  

        $('#engScore'+temp_count).replaceWith('<select class="markInput secured " id="engScore'+temp_count+'" name="engScore'+temp_count+'"></select>');
        $('#mathScore'+temp_count).replaceWith('<select class="markInput secured " id="mathScore'+temp_count+'" name="mathScore'+temp_count+'"></select>');
        $('#sciScore'+temp_count).replaceWith('<select class="markInput secured " id="sciScore'+temp_count+'" name="sciScore'+temp_count+'"></select>');

        $('#engScore'+temp_count).html(grade_options);
        $('#mathScore'+temp_count).html(grade_options);
        $('#sciScore'+temp_count).html(grade_options);
        
      }
    });
  }
  else if(value==-1 || value==-2){
    $('#engScore'+temp_count).replaceWith('<input class="markInput secured" id="engScore'+temp_count+'" name="engScore'+temp_count+'" value=""/>');
    $('#mathScore'+temp_count).replaceWith('<input class="markInput secured" id="mathScore'+temp_count+'" name="mathScore'+temp_count+'" value=""/>');
    $('#sciScore'+temp_count).replaceWith('<input class="markInput secured" id="sciScore'+temp_count+'" name="sciScore'+temp_count+'" value=""/>');
  }
}
