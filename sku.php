<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<link rel="stylesheet" href="css/Sku.css">
<?php 

include('includes/header.php');

$sku = $_REQUEST['sku'];
$supplier = $_REQUEST['supp'];
$result = $SQL->SQLQuery("SELECT * from Intranet.dbo.Certification_Products WHERE SKU = '$sku' AND Supplier = '$supplier'");

$skuFunc = new skuFunc();


?>

<script type="text/javascript">
	$(document).ready(function(){
		var sid = $('#sid').text();
		var sku = $('#sku').val();
		setDropzone('imgDrop', 'posts/uploadImage.php?sku='+sku+'&sid='+sid, 'Drop SKU Image Here');
		setDropzoneNoOnClick('imgDropNoClick', 'posts/uploadImage.php?sku='+sku+'&sid='+sid, 'Drop SKU Image Here');

		$('.datePick').datepicker();
		$('#add').on('click', function(){
		
			
			$.post('getCerts.php', {sku:sku, sid:sid}).done(function(data){
				$('.modal-body').html(data);
				$('#myModal').modal('show');
			})
		})

		$('.submitCert').on('click', function(){
			var certified = $(this).closest('.table').find('tr:eq(0) input').val();
			var certID = $(this).closest('.table').find('tr:eq(0)').find('td:eq(1)').text();
			var certNum = $(this).closest('.table').find('tr:eq(1) input').val();
			var expiry = $(this).closest('.table').find('tr:eq(2) input').val();
			var skuID = $('#hdnID').text();
			alert(skuID);
			$.post('posts/updateCert.php', {certified:certified, certID:certID, certNum:certNum, expiry:expiry, skuID:skuID}).done(function(data){
				console.log(data);
			})
		})

		$('.skuDetails').on('keyup', function(){
			var input = $(this).val()

			if(input.length > 2){
				$(this).closest('tr').find('td:eq(1)').find('span').css('color', 'green')	
			}
			  //find('td:eq(3)').css('color', 'green');
		});

		$(document.body).on('click', '.oi-check', function(){

			if($(this).css('color') === 'green'|| $(this).css('color') === 'rgb(0, 128, 0)'){
				var type = $(this).closest('tr').find('th:eq(0)').text();
				var input = $(this).closest('tr').find('td:eq(0) input').val();
				var sid = $('#sid').text();
				$.post('posts/saveSKUDetail.php', {sid:sid, type:type, input:input}).done(function(data){
					console.log(data)
					
				})
			}
		})

		$('#imgDropNoClick').on('click', function(){
			if($(this).css('background-image') != ''){
				var bg = $(this).css('background-image');
				bg = bg.replace('url(','').replace(')','').replace(/\"/gi, "");

				$("#myModal").modal("show");
    	//sets the image to display
    	$('#modal-image').attr('src', bg);
			}
		})
		

		

		$('.normSelect').on('change', function(){
			var normID = $(this).attr('id');
			var skuID = $('#sid').text();
			var required = $(this).val();
			if($(this).val() == 0)
			{
				$('#mgn'+normID).hide();
				$('#ppc'+normID).hide();
				$(this).css('background-color', 'red');
			}
			else 
			{
				if($('#ppc'+normID).attr('name') === 'set')
				{
					$('#mgn'+normID).show();
					$('#ppc'+normID).show();
				}
				else
				{
					$('#ppc'+normID).show();
				}
				$(this).css('background-color', 'lightgreen');
			}

			$.post('posts/updateNorm.php', {normID:normID, skuID:skuID,required:required}).done(function(data){
				console.log(data);
			});

		});


		$('.oi-paperclip').on('click', function(){
			$('#fileinput').trigger('click');
		})

		$('#fileinput').on('change', function()
		{
			alert($(this).get(0).files[0].name)
		})

	})
</script>
<div class="row" style="margin-top: 1%; margin-bottom: 1%;">
<div class="col-md-5"></div>
<div class="col-md-2"><h1>Results</h1></div>
<div class="col-md-5"></div>
</div>
<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-6">
		<table class="table table-striped" id='SKUTable'>
			<?php 
			while($rows = odbc_fetch_object($result)){
				$sku = $rows->SKU;
				echo "<tr><th>Product SKU</th><td><span><input type='text' class='form-control skuDetails' id='sku' value='$rows->SKU' readonly></td><td id='hdnID' style='display:none;'>$rows->ID</td><td></td></tr>";
				echo "<tr><th>Product Description</th><td><input type='text' class='form-control skuDetails' id='desc' value='$rows->Desc' readonly></td><td></td></tr>";
				echo "<tr><th>Product Type</th><td><input type='text' class='form-control skuDetails' id='type' value='$rows->ProductType'></td><td><span class='oi oi-check'></span></td></tr>";
				echo "<tr><th>Range</th><td><input type='text' class='form-control skuDetails' id='range' value='$rows->Range'></td><td><span class='oi oi-check'></span></td></tr>";
				echo "<tr><th>Supplier</th><td><input type='text' class='form-control skuDetails' id='supp' value='$rows->Supplier' readonly></td><td></td></tr>";
				echo "<tr><th>Supplier Contact</th><td><input type='text' class='form-control skuDetails' id='suppcont' value='$rows->SupplierContact'></td><td><span class='oi oi-check'></span></td></tr><p id='sid' style='display:none;'>$rows->ID</p>";
				$skuID = $rows->ID;
			}

			$img = $skuFunc->checkSKUImage($skuID);
			?>
		</table>

	</div>
	<?php 

	echo $skuFunc->setDropzone($skuID, $sku, $img);

	?>
	<div class="col-md-1"></div>
</div>

<?php 

$certs = $skuFunc->getSKUCerts($skuID);
$count = 1;

while($rows = odbc_fetch_object($certs)){
	if($count === 1){
		echo "<div class='row'>";
		echo "<div class='col-md-1'></div>";
		echo "<div class='col-md-3'>";
		echo "<table class='table table-striped certTable'>";
		echo "<tr><th>".$rows->Certificate." Certified</th><td><input type='text' class='form-control' value='".$rows->Required."'></td><td style='display:none;'>".$rows->ID."</td></tr>";
		echo "<tr><th>".$rows->Certificate." Certificate Number</th><td><input type='text' class='form-control' value='".$rows->CertNumber."'></td></tr>";
		echo "<tr><th>".$rows->Certificate." Expiry</th><td><input type='text' class='form-control datePick' value='".$rows->ExpiryDate."'></td><td style='visibility:hidden;'></td></tr>";
		echo "<tr><th></th><td><input type='button' class='btn btn-secondary submitCert' value='submit'></td></tr>";
		echo "</table>";
		echo "</div>";
		$count = 2;
	} else {
		echo "<div class='col-md-3'>";
		echo "<table class='table table-striped certTable'>";
		echo "<tr><th>".$rows->Certificate." Certified</th><td><input type='text' class='form-control' value='".$rows->Required."'></td><td style='display:none;'>".$rows->ID."</td></tr>";
		echo "<tr><th>".$rows->Certificate." Certificate Number</th><td><input type='text' class='form-control' value='".$rows->CertNumber."'></td></tr>";
		echo "<tr><th>".$rows->Certificate." Expiry</th><td><input type='text' class='form-control datePick' value='".$rows->ExpiryDate."'></td></tr>";
		echo "<tr><th></th><td><input type='button' class='btn btn-secondary submitCert' value='submit'></td></tr>";
		echo "</table>";
		echo "</div>";
		echo "<div class='col-md-1'></div>";
		echo "</div>";
		$count = 1;
	}
}

$norms = $skuFunc->getNorms($skuID);

while($norm = odbc_fetch_object($norms))
{
	echo "<div class='row' style='margin-bottom: 1%;'>";
	echo "<div class='col-md-1'></div>";
	echo "<div class='col-md-2' >$norm->Norm</div>";
	if($norm->Required == 0)
	{
		echo "<div class='col-md-1' style='margin-left:3%; margin-right: -1%;'><select style='background-color:red;' class='form-control normSelect' id='$norm->FK_NormID'><option value='1'>Yes</option><option selected value='0'>No</option></select></div>";
		$ppcStyle = "style='display:none;'";
	}
	else 
	{
		echo "<div class='col-md-1' style='margin-left:3%; margin-right: -1%;'><select style='background-color: lightgreen;' class='form-control normSelect' id='$norm->FK_NormID'><option value='1' selected>Yes</option><option value='0'>No</option></select></div>";
		$ppcStyle = "";
	}

	if($norm->CertLocation != "")
	{
		$set = "set";
	} 
	else 
	{
		$set = "not set";
	}
	
	if($norm->CertLocation == null)
	{
		$mgnStyle = "Style='Display:none;'";
	} 
	else 
	{
		$mgnStyle = "";
	}

	echo "<div class='col-md-1'><span $ppcStyle class='oi oi-paperclip' id='ppc".$norm->FK_NormID."' name='$set'></span><span $mgnStyle class='oi oi-magnifying-glass' id='mgn".$norm->FK_NormID."'></span></div>";
	echo "</div>";
}

?>

</div>



<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      
      <div class="modal-body">
        <img style="max-width: 100%; max-height: 100%;" id="modal-image" src="placeholder">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div class="hiddenfile">
	<input type="file" name='upload' id="fileinput">
</div>