<?php include('include/header.php'); 
$stmtid = $db->prepare("SELECT * FROM tbl_setting where id=1");
$stmtid->execute();
			while($rowid = $stmtid->fetch(PDO::FETCH_ASSOC))
			{
						$details=unserialize($rowid['details']);	
						$pay_details=unserialize($rowid['payment_details']);	
						$image_url=$rowid['image_url'];
						}

?>
    
 <style>
.add_field_button,.remove_field{ padding:5px}
.pay_info input[type="text"]{ width:calc( 100% - 24px ); float:left; border-radius:4px 0px 0px 4px}
.btn { min-height:24px; border-radius:0px 4px 4px 0px}
.gst_rates input { width:32%; float:left}

.img-upload {
	position: absolute;
	top: 50px;
	left: 20%;
	width: 60%;
	border: 2px solid #ccc	;
	border-radius: 5px;
	font-family: 'Helvetica Neue',sans-serif;
	font-size: 16px;
}

.user-image {
	width: 100%;
}
.btn-upload { margin-top:15px;
}


.upload-msg {
	padding: 20px 20px 20px 0;
	float: left;
	text-align: center;	
}
.msg-error {
	color: #ff0000;
}

</style> 
<div class="body-container">

<div class="container">
<div class="row">

<div class="col-md-4">
<div class="col-md-12">
<div class="form-group" style="margin-top:5px">
        <h4>Logo</h4>
        </div>
        
        <div class="form-group img-preview" style="margin-top:5px">
      <img src="<?=url()?>uploads/<?= $image_url ?>" class="img-responsive" width="300px" />
        </div>

        
 <form class="frmUpload" action="" method="post">
            <label>Upload Image:</label>
            <input type="file" name="userImage" id="userImage" class="user-image" required />
            <input type="submit" value="UPLOAD" class="btn-upload btn btn-success" style="border-radius:4px" />        
        </form>
        
        <div class="upload-msg"></div>


</div>
</div>
<form method="post" action="">
<div class="col-md-4">
<div class="col-md-12">

<div class="form-group" style="margin-top:5px">
        <h4>Our Information</h4>
        </div>


<div class="form-group" style="margin-top:5px">
        <input  name="name" class="form-control titleModal" placeholder="Name" value="<?=$details['name']?>"  required="required" type="text" title="Name" data-placement="left">
       
        </div>
        
        <div class="form-group" >
        <input id="textValue" name="gstin" class="form-control titleModal" value="<?=$details['gstin']?>" placeholder="GSTIN"  required="required" type="text" title="Gstin" data-placement="left">
       
        </div>
        <label>GST Rate</label>
        <div class="form-group gst_rates" >
        <input id="textValue" name="gst_rate[]" class="form-control titleModal" placeholder="CGST"  required="required" type="text" title="CGST" data-placement="left" value="<?=$details['gst_rate']['0']?>">
       
       
        <input id="textValue" name="gst_rate[]" class="form-control titleModal" placeholder="SGST"  required="required" type="text" style="margin-left:2%; margin-right:2%" title="SGST" data-placement="top" value="<?=$details['gst_rate']['1']?>">
       
        
        <input id="textValue" name="gst_rate[]" class="form-control titleModal" placeholder="IGST"  required="required" type="text" title="IGST" data-placement="right" value="<?=$details['gst_rate']['2']?>">
       <br />
        </div>
        <label>Address</label>
        <div class="form-group" style="margin-top:5px">
        <input id="textValue" name="address1" class="form-control" placeholder="Address Line 1"  required="required" type="text" value="<?=$details['address1']?>">
       
        </div>
        
        <div class="form-group" style="margin-top:5px">
        <input id="textValue" name="address2" class="form-control" placeholder="Address Line 2"   type="text" value="<?=$details['address2']?>">
       
        </div>
        
        <div class="form-group" style="margin-top:5px">
        <input id="textValue" name="address3" class="form-control" placeholder="Address Line 3"   type="text" value="<?=$details['address3']?>">
       
        </div>
        <label>Contact</label>
         <div class="form-group" style="margin-top:5px">
        <input id="textValue" name="contact" class="form-control" placeholder="Contact No."  type="text" value="<?=$details['contact']?>">
       
        </div>
        
        <div class="form-group" style="margin-top:5px">
        <input id="textValue" name="email" class="form-control" placeholder="Email Id"   type="text" value="<?=$details['email']?>">
       
        </div>

</div>
</div>


<div class="col-md-4">
<div class="col-md-12 pay_info">

<div class="form-group" style="margin-top:5px">
        <h4>Payment Information</h4>
        </div>
       
<div class="input_fields_wrap">

<?php
 
 $cro=count($pay_details);
 for($i=0;$i<$cro;$i++)
 {
  ?>
  <div class="form-group" style="margin-top:5px">
        <input id="payment_info" name="payment_info[]" class="form-control txtval" placeholder="Payment Information " value="<?= $pay_details[$i] ?>"  type="text" onclick="paymentinfo()" onkeyup="paymentinfo()">
       <?php if($i==0){?>
         <a  class="add_field_button btn btn-success btn-xs"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
       <?php }else{?>
       <a class="remove_field btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
       <?php }?>
        </div>
  <?php
 }
  ?>


        
  
  </div>
  
   <div class="form-group" style="margin-top:5px">
        <input type="submit" class="btn btn-success" style="border-radius:4px;" value="Save Setting" />
       
        </div>
        
</div>
</div>
</form>


<?php 
if($_POST){

$namea=$_POST['name'];
$gstnoa=$_POST['gstin'];
$gstrate=$_POST['gst_rate'];
$address1=$_POST['address1'];
$address2=$_POST['address2'];
$address3=$_POST['address3'];
$mobilea=$_POST['contact'];
$emaila=$_POST['email'];
$payment_info=serialize($_POST['payment_info']);
$details='';
$details=array('name'=> $_POST['name'], 'gstin'=>$_POST['gstin'],'gst_rate'=>$_POST['gst_rate'],'address1'=>$_POST['address1'],'address2'=>$_POST['address2'],'address3'=>$_POST['address3'],'contact'=>$_POST['contact'],'email'=>$_POST['email']);
$details=serialize($details);

	$stmt = $db->prepare("UPDATE tbl_setting  SET details=:details,payment_details=:payment_details where id=1");
			$stmt->bindParam(":details",$details);
			$stmt->bindParam(":payment_details",$payment_info);
			
			$stmt->execute();
			
}

?>



</div>
</div>

<div class="panel-footer">
<center><strong>Powerd By <a>taxDoctor</a></strong></center>
</div>
</div>

<script>

$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="form-group" ><input id="payment_info" name="payment_info[]" onclick="paymentinfo()" onkeyup="paymentinfo()" class="form-control txtval" placeholder="Payment Information Line ... " required="required" type="text"><a class="remove_field btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></div>'); //add input box
        }
    });
   
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
	
        e.preventDefault(); $(this).parent('div').remove(); x--;
		calculateSum();
		
    })
});



$(document).ready(function (e) {
	
	$(".frmUpload").on('submit',(function(e) {
		e.preventDefault();
		$(".upload-msg").text('Loading...');	
		$.ajax({
			url: "upload.php",        // Url to which the request is send
			type: "POST",             // Type of request to be send, called as method
			data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       // The content type used when sending data to the server.
			cache: false,             // To unable request pages to be cached
			processData:false,        // To send DOMDocument or non processed data file it is set to false
			success: function(data)   // A function to be called if request succeeds
			{
				$(".upload-msg").html(data);
			}
		});
	}
));

// Function to preview image after validation

$("#userImage").change(function() {
	$(".upload-msg").empty(); 
	var file = this.files[0];
	var imagefile = file.type;
	var imageTypes= ["image/jpeg","image/png","image/jpg"];
		if(imageTypes.indexOf(imagefile) == -1)
		{
			$(".upload-msg").html("<span class='msg-error'>Please Select A valid Image File</span><br /><span>Only jpeg, jpg and png Images type allowed</span>");
			return false;
		}
		else
		{
			var reader = new FileReader();
			reader.onload = function(e){
				$(".img-preview").html('<img class="img-responsive" src="' + e.target.result + '" />');				
			};
			reader.readAsDataURL(this.files[0]);
		}
	});	
});
</script>

<?php include('include/footer.php'); ?>
