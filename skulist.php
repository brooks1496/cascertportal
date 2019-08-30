<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php

include('includes/header.php');

$result = $SQL->SQLQuery('select code, name, pls.SupplierAccountName, pls.PLSupplierAccountID from Sage200_Cassellie_Live.dbo.stockitem si
inner join Sage200_Cassellie_Live.dbo.StockItemSupplier sis on si.ItemID = sis.ItemID
inner join Sage200_Cassellie_Live.dbo.PLSupplierAccount pls on sis.SupplierID = pls.PLSupplierAccountID
left join intranet.dbo.Certification_Products cp on si.Code = cp.SKU
where cp.SKU IS NULL and cp.Supplier IS NULL');


?>
<style type="text/css">
	#skuTable_wrapper{
		margin-top: 5px;
	}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		var url = window.location.href; 
		url = url.split('=');
  		
  		$('#skuTable').dataTable( {
    		"search": {
    			"search" : url[1]
    		}
  		} );

		$(document.body).on('click', '.add', function(){
			var sku = $(this).closest('tr').find('td:eq(0)').text();
			var supplierID = $(this).attr('id');
			window.location.href = 'addsku.php?sku='+sku+"&sid="+supplierID;
		});
	})
</script>
<table id="skuTable" class="table table-striped table-bordered dt-responsive nowrap">
	<thead>
		<tr>
			<th>SKU</th>
			<th>Product Description</th>
			<th>Supplier</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php 

		while($rows = odbc_fetch_object($result)){
			echo "<tr>";
			echo "<td>$rows->code</td>";
			echo "<td>$rows->name</td>";
			echo "<td>$rows->SupplierAccountName</td>";
			echo "<td><input type='button' value='Add' class='add' id='$rows->PLSupplierAccountID'></td>";
			echo "</tr>";
			
		}

		?>
	</tbody>
</table>