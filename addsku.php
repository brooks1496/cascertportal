<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<link rel="stylesheet" href="css/addSku.css">
<?php 

include('includes/header.php');
$SKU = $_REQUEST['sku'];
$SupplierID = $_REQUEST['sid'];

$result = $SQL->SQLQuery("select code, name, pls.SupplierAccountName, pls.PLSupplierAccountID, * from Sage200_Cassellie_Live.dbo.stockitem si
inner join Sage200_Cassellie_Live.dbo.StockItemSupplier sis on si.ItemID = sis.ItemID
inner join Sage200_Cassellie_Live.dbo.PLSupplierAccount pls on sis.SupplierID = pls.PLSupplierAccountID WHERE si.code = '$SKU' AND pls.PLSupplierAccountID = $SupplierID");


?>
<script type="text/javascript">
	$(document).ready(function(){
		setDropzone('imgDrop', 'test.php', 'Drop SKU Image Here');

		$('#add').on('click', function(){
			var sid = $('#sid').text();
			var sku = $('#sku').val();
			
			$.post('getCerts.php', {sku:sku, sid:sid}).done(function(data){
				$('.modal-body').html(data);
				$('#myModal').modal('show');
			})
		})

		$('#saveSKU').on('click', function(){
			var sku = $('#sku').val();
			var sid = $('#sid').text();
			var desc = $('#desc').val();
			var type = $('#type').val();
			var range = $('#range').val();
			var supp = $('#supp').val();
			var suppcont = $('#suppcont').val();
			var cat = $('#catSelect').val();
			
			if($('#subCatSelect').is(":visible"))
			{
				var subCat = $('#subCatSelect').val();
			}
			else 
			{
				var subCat = $('#placeholdSelect').val();
			}
			



			//alert(range);

			if($('#catSelect').val() == 7 || $('#catSelect').val() == 8)
			{
				$.post('posts/manualCerts.php', {sku:sku, sid:sid, desc:desc, type:type, range:range, supp:supp, suppcont:suppcont, cat:cat, subCat:subCat}).done(function(data){

					$('.modal-body').html(data);
					$('#manualModal').modal('show');
				})
			} else 
			{
				$.post('posts/saveSKU.php', {sku:sku, sid:sid, desc:desc, type:type, range:range, supp:supp, suppcont:suppcont, cat:cat, subCat:subCat}).done(function(data){
					console.log(data);
				window.location.href = 'sku.php?sku='+sku+'&supp='+supp; 
				})
			}

			
		})
		
		$('#catSelect').on('change',function(){
			if($(this).val() == 3)
			{
				$('#placeholdSelect').hide();
				$('#subCatSelect').show();
			}
			else 
			{
				$('#placeholdSelect').show();
				$('#subCatSelect').hide()
			}
		})
	})
</script>
<div class="container-fluid">
<div class="row">
	<div class="col-md-8">
		<table class="table">
			<?php 
			while($rows = odbc_fetch_object($result)){
				echo "<tr><th>Product SKU</th><td><input type='text' class='form-control' id='sku' value='$rows->code'></td></tr>";
				echo "<tr><th>Product Description</th><td><input type='text' class='form-control' id='desc' value='$rows->name'></td></tr>";
				echo "<tr><th>Product Type</th><td><input type='text' class='form-control' id='type'></td></tr>";
				echo "<tr><th>Product Category</th><td>";
				echo "<select class='form-control' id='catSelect'>";
				$result2 = $SQL->SQLQuery("SELECT * from intranet.dbo.certification_categories");
				while($row = odbc_fetch_object($result2))
				{
					echo "<option value='$row->ID'>$row->Category</option>";
				}
				echo "</select>";
				echo "</td></tr>";
				echo "<tr><th>Subcategory</th><td>";
				echo "<select class='form-control' id='placeholdSelect'><option value='null'>N/A</option></select>";
				echo "<select class='form-control' id='subCatSelect' style='display:none;'>";
				$result2 = $SQL->SQLQuery("SELECT * from intranet.dbo.certification_SubCat");
				while($row = odbc_fetch_object($result2))
				{
					echo "<option value='$row->ID'>$row->Subcategory</option>";
				}
				echo "</select>";

				echo "</td></tr>";
				echo "<tr><th>Range</th><td><input type='text' class='form-control' id='range'></td></tr>";
				echo "<tr><th>Supplier</th><td><input type='text' class='form-control' id='supp' value='$rows->SupplierAccountName'></td></tr>";
				echo "<tr><th>Supplier Contact</th><td><input type='text' class='form-control' id='suppcont'></td></tr><p id='sid' style='display:none;'>$SupplierID</p>";
			}
			?>
		</table>

	</div>
	<div class="col-md-4">
		<div class="container" id="dropTbl">
			<div class="dropzone" id="imgDrop">
		
			</div>
		</div>
	</div>
</div>
<div class="row">
<div class="col-md-8">
	<input type="button" class="btn btn-secondary" style="float: right; margin-right: 1%;" value="Save SKU" id="saveSKU">
</div>

</div>
</div>



<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      
      <div class="modal-body">
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>



<div id="manualModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      
      <div class="modal-body">
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>