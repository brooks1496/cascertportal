<?php 

include('../includes/auth.php');

$sku = $_REQUEST['sku'];
$desc = $_REQUEST['desc'];
$type  = $_REQUEST['type'];
$range = $_REQUEST['range'];
$supp = $_REQUEST['supp'];
$suppcont = $_REQUEST['suppcont'];
$cat = $_REQUEST['cat'];
$subCat = $_REQUEST['subCat'];


$result = $SQL->SQLQuery("INSERT INTO Intranet.dbo.Certification_Products VALUES ('$sku', '$desc', '$type', '$range', '$supp', '$suppcont', $cat, $subCat)");
	
$skuVal = $SQL->SQLQuery("SELECT ID From intranet.dbo.Certification_Products where SKU = '$sku' AND Supplier = '$supp'");
$skuID = odbc_result($skuVal, 1);
if(odbc_num_rows($skuVal) > 0)
{
	if($subCat != 'null')
	{
		$result2 = $SQL->SQLQuery("SELECT ID from Intranet.dbo.Certification_Norms where FK_CategoryID = $cat AND FK_SubCategoryID = $subCat");
		
	} 
	else 
	{
		if($cat == '7' || $cat == '8')
		{
			$norms = $_REQUEST['norms'];
			$cnt = count($norms); 
			for($a = 0; $a < $cnt; $a++)
			{
				$result2 = $SQL->SQLQuery("INSERT INTO Intranet.dbo.Certification_LKNorms (FK_NormID, FK_ProductID) VALUES (".$norms[$a].", ".$skuID.")");
			}
		} 
		else 
		{
			$result2 = $SQL->SQLQuery("SELECT ID from Intranet.dbo.Certification_Norms where FK_CategoryID = $cat");
		}

			
		
	}
	if($cat == '7' || $cat == '8')
	{

	}
	else 
	{
	while($row = odbc_fetch_object($result2))
	{
		$ins = $SQL->SQLQuery("INSERT INTO intranet.dbo.Certification_LKNorms (FK_NormID, FK_ProductID) VALUES ($row->ID , $skuID)");

	}
	}

}





?>