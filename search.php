<?php 

include('includes/header.php');
?>
<script>
$('document').ready(function(){
		$(".clickable-row").click(function(){
			var url = $(this).data("href");
			//alert(itemcode);
			window.location = url;
		});
	})
</script>

<?php

$skuFunc = new SKUFunc();

$check = $skuFunc->checkSKUinDB($_REQUEST['srcInput']);

$search = $skuFunc->searchSKU($_REQUEST['srcInput']);
?>