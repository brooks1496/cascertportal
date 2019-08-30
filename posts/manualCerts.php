<?php 

include('../includes/auth.php');

?>

<script type="text/javascript">
	$(document).ready(function(){
		$(document.body).on('click', '.secondarySave', function(){
		
			var tbl = $('#normTbl tbody');
			var leng = $("#normTbl td").length;
			leng = leng/2;
			//alert(leng)
			var checked = [];
			var idArr = $(this).attr('id').split("|");
			var sku = idArr[0];
			var sid = idArr[1];
			var desc = idArr[2];
			var type = idArr[3];
			var range = idArr[4];
			var supp = idArr[5];
			var suppcont = idArr[6];
			var cat = idArr[7];
			var subCat = idArr[8];



			for(i = 0; i < leng; i++)
			{
				var val = tbl.find('tr:eq('+i+')').find('td input').val();

				if(tbl.find('tr:eq('+i+')').find('td input').is(':checked') == true )
				{
					checked.push(val);
				}
			}

			$.post('posts/saveSKU.php', {sku:sku, sid:sid, desc:desc, type:type, range:range, supp:supp, suppcont:suppcont, cat:cat, subCat:subCat, norms:checked}).done(function(data){
					console.log(data);
				window.location.href = 'sku.php?sku='+sku+'&supp='+supp; 
				})

		})

		



	});
</script>

<?php

$result = $SQL->SQLQuery("SELECT * from intranet.dbo.Certification_Norms");

echo "<h3 style='text-align: center;'>Please select the certifications relevant to this product</h3><br>";

echo "<table class='table' id='normTbl'>";

while($rows = odbc_fetch_object($result))
{
	echo "<tr><th>$rows->Norm</th><td><input type='checkbox' value='$rows->ID'></td></tr>";
}

echo "</table>";

$idString = $_REQUEST['sku']."|".$_REQUEST['sid']."|".$_REQUEST['desc']."|".$_REQUEST['type']."|".$_REQUEST['range']."|".$_REQUEST['supp']."|".$_REQUEST['suppcont']."|".$_REQUEST['cat']."|".$_REQUEST['subCat'];

echo "<br> <input type='button' value='Save SKU' class='btn btn-secondary secondarySave' id='".$idString."' style='float:right;'>"

?>