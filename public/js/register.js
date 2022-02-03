function pw_in_hid($required_or_not){
  var adm = document.getElementById("password_for_assignment");
  adm.style.display = "none";
  var $elementReference = document.getElementById("pw_box_adm");
  $elementReference.required = $required_or_not;
}

function pw_in_dis($required_or_not){
  var adm = document.getElementById("password_for_assignment");
  adm.style.display = "block";
  var $elementReference = document.getElementById("pw_box_adm");
  $elementReference.required = $required_or_not;
}