<?php
require_once("../dbcon.php");
$htm = '';
if($_GET){
  $device_id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
  $sql="select *,device_data.id as ddid from device_data left join devices on devices.id = device_data.device_id where device_data.device_id=".$device_id." ORDER BY date_time DESC";
  $details = array();
  if(!$result = $conn->query($sql)){
    echo $conn->error;
  }
  else
  {
    while ($rows = $result->fetch_assoc()) {
     $details[] = $rows;
   }  

 }
 $htm .=' <table class="table table-bordered table-hover" id="example">
 <thead>
 <tr>
 <th>Sr. No.</th>
 <th>Date & Time</th>
 <th>Value</th>
 <th>Unit</th>
 <th>Temp (deg C)</th>
 <th>Action</th>
 </tr>
 </thead>
 <tbody>';
 $i=1; foreach ($details as $key) { 
  $htm .= '<tr>';
  $htm .= '<td>'.$i.'</td>';
  $htm .= '<td>'.$key['date_time'].'</td>';
  $htm .= '<td>'.$key['value1'].'</td>';
  $htm .= '<td>'.$key['value2'].'</td>';
  $htm .= '<td>'.$key['value3'].'</td>';
  $htm .= '<td><a  class="btn btn-danger delancid" id="'.$key['ddid'].'" href="javascript:void(0)">Delete</a></td>';
  $htm .= '</tr>';  
  $i++;
} 
}
$htm .=' </tbody>
</table>';
echo $htm;
?>
<script type="text/javascript">
   $(document).ready(function() {
    $('#example').DataTable( {
      dom: 'Bfrtip',
      buttons: [
      'csv', 'excel'
      ]
    } );
  } );

   $( ".delancid" ).click(function() {
       var id = $(this).attr( "id" )
        if(confirm('Are You sure?')){
        $.ajax({
        type: "GET",
        url: "deletedevicedata.php?id="+id,
        success: function(result){
          if(result==true){
             $("#"+id).closest('tr').remove();
          }else{
            alert('Something went wrong!');
          }
        }
      });
      }
    });
</script>
