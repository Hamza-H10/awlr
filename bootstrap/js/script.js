function Validatepaymeny()
            {
                var e = document.getElementById("ddlView");
                var strUser = e.options[e.selectedIndex].value;

                var strUser1 = e.options[e.selectedIndex].text;
                if(strUser==0)
                {
                    $("#paydis").css("display", "none"); 
					$("#payment_ex").css("display", "none");
					
                }
				else{
					
					$("#paydis").removeAttr("style");
					$("#payment_ex").removeAttr("style");
					}
            }
			
			
			
			function Validatepaymeny1()
            {
                var e = document.getElementById("ddtView");
                var strUser2 = e.options[e.selectedIndex].value;

                var strUser12 = e.options[e.selectedIndex].text;
                if(strUser2==0)
                {
                    $("#paydisref").css("display", "none"); 
					
					
                }
				else if(strUser2==1){
					
					 $("#paydisref").css("display", "none"); 
					
					}
					else if(strUser2==2){
					
					$("#paydisref input").attr("placeholder", "Online Transection Id");
					$("#paydisref").removeAttr("style");
					
					}
					else if(strUser2==3){
					
					$("#paydisref input").attr("placeholder", "Enter Check Number");
					$("#paydisref").removeAttr("style");
					
					}
            }


$('#Outertd').delegate('#checkgst', 'change', function () {
    if (!this.checked) {
		
       
	   $("#trigst").css("display", "none");
        $("#trsgst").removeAttr("style");
		$("#trcgst").removeAttr("style");
       calculateSum();
    }
	else{
		 $("#trcgst").css("display", "none");
		$("#trsgst").css("display", "none");
		$("#trigst").removeAttr("style");
		calculateSum();
		}
});



function copyValuestat() {
    var valueToCopy = document.getElementById("state_in").value;
    var elem = document.getElementById("state_ad");
    elem.value = valueToCopy;
	shipstate(valueToCopy);
}

function copyValue() {
    var valueToCopy = document.getElementById("textValue").value;
    var elem = document.getElementById("mytext");
    elem.value = valueToCopy;
}
function copyValue2() {
    var valueToCopy = document.getElementById("textValue2").value;
    var elem = document.getElementById("mytext2");
    elem.value = valueToCopy;
}
function copyValue3() {
    var valueToCopy = document.getElementById("textValue3").value;
    var elem = document.getElementById("mytext3");
    elem.value = valueToCopy;
}
function copyValue4() {
    var valueToCopy = document.getElementById("textValue4").value;
    var elem = document.getElementById("mytext4");
    elem.value = valueToCopy;
}
function copyValue5() {
    var valueToCopy = document.getElementById("textValue5").value;
    var elem = document.getElementById("mytext5");
    elem.value = valueToCopy;
}
function copyValue6() {
    var valueToCopy = document.getElementById("textValue6").value;
    var elem = document.getElementById("mytext6");
    elem.value = valueToCopy;
}
function copyValue7() {
    var valueToCopy = document.getElementById("textValue7").value;
    var elem = document.getElementById("mytext7");
    elem.value = valueToCopy;
}


$('.datepicker').datepicker();



function select_client(id){
	
	//alert(id);clcvm-
	var cname=document.getElementById('clcvn-'+id).value;
	var cpan=document.getElementById('clcvp-'+id).value;
	var cmob=document.getElementById('clcvm-'+id).value;
	var ceml=document.getElementById('clcve-'+id).value;
	var cstat=document.getElementById('clcvs-'+id).value;
	var cadr=document.getElementById('clcva-'+id).value;
	
	var cgstin=document.getElementById('clcvg-'+id).value;
	var cplsup=document.getElementById('clcvps-'+id).value;
	
	$("#textValue").val(cname);
	copyValue();
	
	$("#textValue3").val(cpan);
	copyValue3();
	$("#textValue2").val(cmob);
	copyValue2();
	$("#textValue4").val(ceml);
	copyValue4()
	$("#state_in").val(cstat);
	billstate(cstat);
	
	$("#textValue5").val(cadr);
	copyValue5()
	$("#textValue6").val(cgstin);
	copyValue6()
	$("#textValue7").val(cplsup);
	copyValue7()
	}

//document.getElementById("Mobility").selectedIndex = 12;
function butcl(){

		//iterate through each textboxes and add keyup
		//handler to trigger sum event
		$(".txtcal").each(function() {

			$(this).keyup(function(){
				calculateSum();
			});
		});

	};

 

	