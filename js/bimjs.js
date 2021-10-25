jQuery(document).ready(function() {
    jQuery('#first_form').submit(function(e) {
        e.preventDefault();
    var txtFeet = jQuery('#txtFeet').val();
    var txtInches = jQuery('#txtInches').val();
    var  txtPounds = jQuery('#txtPounds').val();
     jQuery(".error").remove();
     
      if (txtFeet.length < 1) {
      jQuery('#txtFeet').after('<span class="error">Please enter a feet</span>');
      jQuery(".error").show().delay(2000).fadeOut();
    }
     if (txtInches.length < 1) {
      jQuery('#txtInches').after('<span class="error">Please enter a inches</span>');
      jQuery(".error").show().delay(2000).fadeOut();
    }
     if (txtPounds.length < 1) {
      jQuery('#txtPounds').after('<span class="error">Please enter a pounds</span>');
      jQuery(".error").show().delay(2000).fadeOut();
    }
    });  
});
jQuery(document).ready(function() {
    jQuery('#first_form_two').submit(function(e) {
        e.preventDefault();
    var height = jQuery('#height').val();
    var weight = jQuery('#weight').val();
     jQuery(".error").remove();
     
      if (height.length < 1) {
      jQuery('#height').after('<span class="error">Please enter a height</span>');
      jQuery(".error").show().delay(2000).fadeOut();
    }
     if (weight.length < 1) {
      jQuery('#weight').after('<span class="error">Please enter a weight</span>');
      jQuery(".error").show().delay(2000).fadeOut();
    }
    return false;
    });  
});

function openbmi(evt, bmiName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(bmiName).style.display = "block";
  evt.currentTarget.className += " active";
}

function calculateBmi() {
var weight = document.bmiForm.weight.value;
var height = document.bmiForm.height.value;
	
var finalBmi = weight/(height/100*height/100);
var finalscore = document.bmiForm.bmi.value = finalBmi.toFixed(1);

    if(finalBmi >= 18.5 && finalBmi <= 25 ){

        jQuery('#overweight, .overweight').hide();   
        jQuery('#underweight, .underweight ').hide();        
        jQuery('#obeserange, .obeserange ').hide();      
        jQuery('#normalrange, .normalrange').show();
        jQuery('.pbmiscore').text(finalscore);
        jQuery('.pheight').text(height);
        jQuery('.pweight').text(weight);        
        jQuery('.custommodal ').show();
        
        
    }else if(finalBmi >= 25 && finalBmi <= 30 ){

        jQuery('#normalrange, .normalrange').hide();
        jQuery('#underweight, .underweight ').hide();
        jQuery('#obeserange, .obeserange').hide();      
        jQuery('#overweight, .overweight').show();        
        jQuery('.pbmiscore').text(finalscore);
        jQuery('.pheight').text(height);
        jQuery('.pweight').text(weight);        
        jQuery('.custommodal').show();

        
    }else if(finalBmi >= 30 ){

        jQuery('#normalrange, .normalrange').hide();
        jQuery('#underweight, .underweight ').hide();
        jQuery('#obeserange, .obeserange').show();      
        jQuery('#overweight, .overweight').hide();        
        jQuery('.pbmiscore').text(finalscore);
        jQuery('.pheight').text(height);
        jQuery('.pweight').text(weight);        
        jQuery('.custommodal').show();

        
    }else if(finalBmi <= 18.5 ){

        jQuery('#normalrange, .normalrange').hide();
        jQuery('#obeserange, .obeserange').hide();
        jQuery('#underweight, .underweight ').show();      
        jQuery('#overweight, .overweight').hide();        
        jQuery('.pbmiscore').text(finalscore);
        jQuery('.pheight').text(height);
        jQuery('.pweight').text(weight);        
        jQuery('.custommodal').show();
        
    }
    
}

function calcEnglish(form, feet, inches, pounds) {
   if ((! inches) || isNaN(inches))
     inches = 0;
   TotalInches = eval(feet*12) + eval(inches);
   Temp = pounds / (TotalInches * TotalInches);
   form.txtBMI.value = Math.round((Temp * 703) * 10) / 10;
   
   var result=Math.round((Temp * 703) * 10) / 10;
 
   
    if(result >= 18.5 && result <= 25 ){

        jQuery('#overweight, .overweight').hide();   
        jQuery('#underweight, .underweight ').hide();        
        jQuery('#obeserange, .obeserange').hide();      
        jQuery('#normalrange, .normalrange').show();
        jQuery('.pheight').text(feet+' Feet '+inches+' Inches');
        jQuery('.pweight').text(pounds);
        jQuery('.pbmiscore').text(result);
        jQuery('.custommodal').show();
        
    }else if(result >= 25 && result <= 30 ){

        jQuery('#normalrange, .normalrange').hide();
        jQuery('#underweight, .underweight ').hide();
        jQuery('#obeserange, .obeserange').hide();      
        jQuery('#overweight, .overweight').show();        
        jQuery('.pheight').text(feet+' Feet '+inches+' Inches');
        jQuery('.pweight').text(pounds); 
        jQuery('.pbmiscore').text(result);        
        jQuery('.custommodal').show();

        
    }else if(result >= 30 ){

        jQuery('#normalrange, .normalrange').hide();
        jQuery('#underweight, .underweight ').hide();
        jQuery('#obeserange, .obeserange').show();      
        jQuery('#overweight, .overweight').hide();        
        jQuery('.pheight').text(feet+' Feet '+inches+' Inches');
        jQuery('.pweight').text(pounds); 
        jQuery('.pbmiscore').text(result);        
        jQuery('.custommodal').show();

        
    }else if(result <= 18.5 ){

        jQuery('#normalrange, .normalrange').hide();
        jQuery('#obeserange, .obeserange').hide();
        jQuery('#underweight, .underweight ').show();      
        jQuery('#overweight, .overweight').hide();        
        jQuery('.pheight').text(feet+' Feet '+inches+' Inches');
        jQuery('.pweight').text(pounds);
        jQuery('.pbmiscore').text(result);        
        jQuery('.custommodal').show();
        
    }
}

function calcMetric(form, meters, kilograms) {
	Temp = kilograms / (meters * meters)	;
	form.txtBMI.value = Math.round(Temp * 10) / 10;
}

function calcMeters(form, feet, inches) {
   if ((! inches) || isNaN(inches))
     inches = 0;
   TotalInches = eval(feet*12) + eval(inches);
   Temp = (TotalInches * 2.54) / 100;
   form.txtMeters.value = Math.round(Temp * 10) / 10;
}

function calcFeetInches(form, meters) {
   temp = eval((meters * 100) / 2.54);
   feet = Math.floor((temp / 12))
   form.txtFeet.value = feet;
	if (temp > (feet * 12))
		form.txtInches.value = Math.round((temp - (feet * 12)) * 10) / 10
	else
		form.txtInches.value = '';
}

function calcKilograms(form, pounds) {
   Temp = (pounds * .45);
   form.txtWeight.value = Math.round(Temp * 10) / 10;
}

function calcPounds(form, kilograms) {
   Temp = (kilograms / .45);
   form.txtPounds.value = Math.round(Temp * 10) / 10;
}

jQuery(document).ready(function() {
    jQuery('#close').on('click',function() {
         jQuery('.custommodal').css('display','none');
    });
});
