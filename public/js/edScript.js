/*

******************* This code is scripted by Rohit Nair.

*/

var count;

$(document).ready(function(){

  var window_width = $(window).width();
  var window_height = $(window).height();
  var container_width = $('.container').width();
  $('#fixed-top-div').css({
    width: container_width,
    left: (window_width/2) - (container_width/2) + 12,
  });

  $('.cover').css({
    width: window_width,
    height: window_height
  });

  $('.cover').delay(1500).fadeOut(2000);

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

  $('form').not('#selectCity').change(function(e){
    if(this.id=='updateScores'){ /* The AJAX script needs to run only for the form with id as updateScores */
      var link = window.location.toString();
      var n = link.indexOf('/assessment');
      if(n>=0){
        if(validate_form()){
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
        }
        else{
          document.getElementById('updateSuccess').innerHTML = '<br/><div class="chip error">Validation Error<i class="material-icons">close</i></div>';
        }
      }
    }
  });



  $('.masterSelect').change(function(e) {
    $('.cover').fadeIn(200);
    var id = this.id;
    
    //$('.'+id).val(this.value);

    var flag = false;

    var classname = '.'+id;
    var length = $(classname).length;
    var data = this.value;

    for(i=0;i<length;i++){
      var element = $(classname)[i];
      template_id = element.id;
      var temp_count = template_id.substring(8,10);

      engScore = document.getElementById('engScore'+temp_count).value;
      sciScore = document.getElementById('sciScore'+temp_count).value;
      mathScore = document.getElementById('mathScore'+temp_count).value;
      studentName = document.getElementById('studentName'+temp_count).value;
      

      if((engScore!="" || mathScore!="" || sciScore!="") && (engScore!="0" || mathScore!="0" || sciScore!="0") && !flag){
        var check = confirm('Updated scores MAY BE deleted for '+studentName+' and others.');
        if(check){
          flag = true;
          $('#template'+temp_count).val(this.value);
          getGrades(template_id);          
        }
        else{

        }
      }
      else{
        $('#template'+temp_count).val(this.value);
        getGrades(template_id);
      }

    }
    $('.cover').fadeOut(200);
  });

    /*var base_url = window.location;
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

            engScore = document.getElementById('engScore'+temp_count).value;
            sciScore = document.getElementById('sciScore'+temp_count).value;
            mathScore = document.getElementById('mathScore'+temp_count).value;

            if(engScore!="" || mathScore!=""|| sciScore!=""){
              break;
            }

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

        engScore = document.getElementById('engScore'+temp_count).value;
        sciScore = document.getElementById('sciScore'+temp_count).value;
        mathScore = document.getElementById('mathScore'+temp_count).value;

        $('#engScore'+temp_count).replaceWith('<input class="markInput secured" id="engScore'+temp_count+'" name="engScore'+temp_count+'" value="'+engScore+'"/>');
        $('#mathScore'+temp_count).replaceWith('<input class="markInput secured" id="mathScore'+temp_count+'" name="mathScore'+temp_count+'" value="'+mathScore+'"/>');
        $('#sciScore'+temp_count).replaceWith('<input class="markInput secured" id="sciScore'+temp_count+'" name="sciScore'+temp_count+'" value="'+sciScore+'"/>');

        if(value==-1){
          $('#totalEng'+temp_count).show();
          $('#totalMath'+temp_count).show();
          $('#totalSci'+temp_count).show();
          $('.total'+temp_count).show();
        }
        else{
          if(engScore <= 10 && mathScore <= 10 && sciScore <= 10){ 
            $('#totalEng'+temp_count).hide();
            $('#totalMath'+temp_count).hide();
            $('#totalSci'+temp_count).hide(); 
            $('.total'+temp_count).hide();
          } 
        }
      }
    }
  });*/

  
  $('.studentGrade').change(function(e){
    $('.cover').fadeIn(200);
    var id = this.id;
    var temp_count = id.substring(8,10);

    engScore = document.getElementById('engScore'+temp_count).value;
    sciScore = document.getElementById('sciScore'+temp_count).value;
    mathScore = document.getElementById('mathScore'+temp_count).value;
    studentName = document.getElementById('studentName'+temp_count).value;

    if((engScore!="" || mathScore!="" || sciScore!="") && (engScore!="0" || mathScore!="0" || sciScore!="0")){
      var check = confirm('Updated scores MAY BE deleted for '+studentName+'.');
      if(check){
        $('#template'+temp_count).val(this.value);
        getGrades(id);          
      }
      else{

      }
    }
    $('#template'+temp_count).val(this.value);
    getGrades(id);   
    $('.cover').fadeOut(200);
  });


//Adding and Removing Rows in the Grade Template Creation

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
  //alert(value);
  var data = value;

  if(value==-1){
    engScore = document.getElementById('engScore'+temp_count).value;
    sciScore = document.getElementById('sciScore'+temp_count).value;
    mathScore = document.getElementById('mathScore'+temp_count).value;
    $('#totalEng'+temp_count).show();
    $('#totalMath'+temp_count).show();
    $('#totalSci'+temp_count).show();
    $('.total'+temp_count).show();

    $('#engScore'+temp_count).replaceWith('<input class="markInput secured" id="engScore'+temp_count+'" name="engScore'+temp_count+'" value="'+engScore+'"/>');
    $('#mathScore'+temp_count).replaceWith('<input class="markInput secured" id="mathScore'+temp_count+'" name="mathScore'+temp_count+'" value="'+mathScore+'"/>');
    $('#sciScore'+temp_count).replaceWith('<input class="markInput secured" id="sciScore'+temp_count+'" name="sciScore'+temp_count+'" value="'+sciScore+'"/>');
  }
  else if(value==-2){
    engScore = document.getElementById('engScore'+temp_count).value;
    sciScore = document.getElementById('sciScore'+temp_count).value;
    mathScore = document.getElementById('mathScore'+temp_count).value;
    if((engScore <= 10 && mathScore <= 10 && sciScore <= 10)||(!Number.isInteger(engScore) || !Number.isInteger(mathScore) || !Number.isInteger(sciScore))){ 
      $('.total'+temp_count).hide();
      $('#totalEng'+temp_count).hide();
      $('#totalMath'+temp_count).hide();
      $('#totalSci'+temp_count).hide();
    }
    else{
      document.getElementById(template).value = -1;
    }

    $('#engScore'+temp_count).replaceWith('<input class="markInput secured" id="engScore'+temp_count+'" name="engScore'+temp_count+'" value="'+engScore+'"/>');
    $('#mathScore'+temp_count).replaceWith('<input class="markInput secured" id="mathScore'+temp_count+'" name="mathScore'+temp_count+'" value="'+mathScore+'"/>');
    $('#sciScore'+temp_count).replaceWith('<input class="markInput secured" id="sciScore'+temp_count+'" name="sciScore'+temp_count+'" value="'+sciScore+'"/>');
  }
  else if(value>=0){
    $('.total'+temp_count).hide();
    $('#totalEng'+temp_count).hide();
    $('#totalMath'+temp_count).hide();
    $('#totalSci'+temp_count).hide();
    var base_url = window.location;
    $.ajax({
      type: "POST",
      url: base_url + "/fetchTemplate/"+value,
      data: data,
      success: function(data){

        var parsed = JSON.parse(data);
        var grade_options = '<option value="0" selected>Not Available</option>';

        engScore = document.getElementById('engScore'+temp_count).value;
        sciScore = document.getElementById('sciScore'+temp_count).value;
        mathScore = document.getElementById('mathScore'+temp_count).value;

        for (i=0;i<parsed.grade.length;i++){
          grade_options += '<option value="'+parsed.grade[i].grade+'">'+parsed.grade[i].grade+'</option>';
        }

        //alert(grade_options);
        var selectEng = '<select class="markInput secured " id="engScore'+temp_count+'" name="engScore'+temp_count+'">';
        var selectMath = '<select class="markInput secured " id="mathScore'+temp_count+'" name="mathScore'+temp_count+'">';
        var selectSci = '<select class="markInput secured " id="sciScore'+temp_count+'" name="sciScore'+temp_count+'">';

        $('#engScore'+temp_count).replaceWith('<select class="markInput secured " id="engScore'+temp_count+'" name="engScore'+temp_count+'"></select>');
        $('#mathScore'+temp_count).replaceWith('<select class="markInput secured " id="mathScore'+temp_count+'" name="mathScore'+temp_count+'"></select>');
        $('#sciScore'+temp_count).replaceWith('<select class="markInput secured " id="sciScore'+temp_count+'" name="sciScore'+temp_count+'"></select>');

        $('#engScore'+temp_count).html(grade_options);
        $('#mathScore'+temp_count).html(grade_options);
        $('#sciScore'+temp_count).html(grade_options);

        if(engScore!=""){
          $('#engScore'+temp_count).val(engScore).change();
        }
        if(mathScore!=""){
          $('#mathScore'+temp_count).val(mathScore).change();
        }
        if(sciScore!=""){
          $('#sciScore'+temp_count).val(sciScore).change();
        }
      }
    });
  }
}

function validate_form(){

  var length = $('.gradeSelect').length;
  var engScore = 'engScore'+temp_count;
  var mathScore = 'mathScore'+temp_count;
  var sciScore = 'sciScore'+temp_count;
  var totalEng = 'totalEng'+temp_count;
  var totalMath = 'totalMath'+temp_count;
  var totalSci = 'totalSci'+temp_count;
    
  var validate = true;

  for (var i=0;i<length;i++){
    var template = 'template'+i;
    var temp_count = i;
    var template_value = document.getElementById(template).value;
    if(template_value == -1){
      engScore = parseFloat(document.getElementById('engScore'+temp_count).value);
      mathScore = parseFloat(document.getElementById('mathScore'+temp_count).value);
      sciScore = parseFloat(document.getElementById('sciScore'+temp_count).value);
      totalEng = parseFloat(document.getElementById('totalEng'+temp_count).value);
      totalMath = parseFloat(document.getElementById('totalMath'+temp_count).value);
      totalSci = parseFloat(document.getElementById('totalSci'+temp_count).value);

      if(engScore>totalEng){
        $('#engScore'+temp_count).addClass('error');
        validate = false;
      }
      if(sciScore>totalSci){
        $('#sciScore'+temp_count).addClass('error');
        validate = false;
      }
      if(mathScore>totalMath){
        $('#mathScore'+temp_count).addClass('error');
        validate = false;
      }
    }
    else if(template_value == -2){
      engScore = document.getElementById('engScore'+temp_count).value;
      mathScore = document.getElementById('mathScore'+temp_count).value;
      sciScore = document.getElementById('sciScore'+temp_count).value;
      
      if(engScore>10 || engScore <0){
        $('#engScore'+temp_count).addClass('error');
        validate = false; 
      }
      if(mathScore>10 || mathScore <0){
        $('#mathScore'+temp_count).addClass('error');
        validate = false; 
      }
      if(sciScore>10 || sciScore <0){
        $('#sciScore'+temp_count).addClass('error');
        validate = false; 
      }
    }
  }
  if(validate){
    for (var i=0;i<length;i++){
      $('#engScore'+temp_count).removeClass('error');
      $('#mathScore'+temp_count).removeClass('error');
      $('#sciScore'+temp_count).removeClass('error');
    }
  }
  return validate;      
}