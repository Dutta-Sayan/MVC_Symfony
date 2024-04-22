$(document).ready(function(){
  $('body').on("click",'#addRow', function(){
    var length = $('.sl').length;
    var i = parseInt(length)+parseInt(1);
  
    var newrow = $('.next-ques').append('<div class="set-ques"><span class="set-ques-heading ques-form-heading">Add your question below</span><br><input type="text" name="slno[]" class="sl" id="slno" value="'+i+'" readonly=""><br><textarea name="ques[]" id="question'+i+'" cols="30" rows="5"></textarea><br><div class="answers"><span class="add-options-heading ques-form-heading">Add Options</span><br><input type="text" name="optionA[]" id="opA'+i+'" placeholder="Enter first option"><br><input type="text" name="optionB[]" id="opB'+i+'" placeholder="Enter second option"><br><input type="text" name="optionC[]" id="opC'+i+'" placeholder="Enter third option"><br><span class="correct-answer-heading ques-form-heading">Enter correct answer</span><br><input type="text" name="answer[]" id="ans'+i+'" placeholder="Enter correct answer"><br><span class="ques-marks ques-form-heading">Enter the marks for this question</span><br><input type="number" name="marks[]" id="marks'+i+'" placeholder="Enter the marks"><br><button type="button" name="addRow" id="addRow" class="btn btn-success pull-right">Add Row</button><input type="button" class="btnRemove btn-danger" value="remove"/></div>');
  });
  $('body').on('click', '.btnRemove', function(){
    $(this).closest('.set-ques').remove();
  });
});
