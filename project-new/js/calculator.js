var JQ = jQuery.noConflict();
function add_value(input, character) {
	if(input.value == null || input.value == "0")
		input.value = character
	else
		input.value += character
}

function cos(form) {
	form.display.value = Math.cos(form.display.value);
}

function sin(form) {
	form.display.value = Math.sin(form.display.value);
}

function tan(form) {
	form.display.value = Math.tan(form.display.value);
}

function sqrt(form) {
	form.display.value = Math.sqrt(form.display.value);
}

function ln(form) {
	form.display.value = Math.log(form.display.value);
}

function exp(form) {
	form.display.value = Math.exp(form.display.value);
}

function deleteChar(input) {
	input.value = input.value.substring(0, input.value.length - 1)
}

function changeSign(input) {
	if(input.value.substring(0, 1) == "-")
		input.value = input.value.substring(1, input.value.length)
	else
		input.value = "-" + input.value
}


function compute(form) {
var x= form.display.value = eval(form.display.value)
 //alert (x);    
 document.getElementById("showval").value =x;
}

function square(form) {
	form.display.value = eval(form.display.value) * eval(form.display.value)
}

function checkNum(str) {
	for (var i = 0; i < str.length; i++) {
		var ch = str.substring(i, i+1)
		if (ch < "0" || ch > "9") {
			if (ch != "/" && ch != "*" && ch != "+" && ch != "-" && ch != "."
				&& ch != "(" && ch!= ")") {
				alert("invalid entry!")
				return false
				}
			}
		}
		return true
}

JQ(document).on("click",".calculator",function() {
    
    var calc_id = JQ(this).attr("id");
//    alert(calc_id);return false;
    var split = calc_id.split("-");
    var counter = split[split.length -2];
    var textbox_id = split[split.length -3];
    JQ('#textbox_id').text(textbox_id+'-'+counter);   
});
//JQ(document).on('click','#calc_close',function(){
//    var textbox_id =JQ('#textbox_id').text();
//    var calc_value=JQ('#display_cacl_value').val();
//    JQ('#'+textbox_id).val(calc_value);
//    JQ('#textbox_id').text("");
//}); 