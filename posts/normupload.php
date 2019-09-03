<?php 


include('../includes/auth.php');

//grab these from the url
$skuID = $_REQUEST['skuID'];
$normID = $_REQUEST['normID'];


//get the sku name for folder creation
$skuResult =$SQL->SQLQuery("SELECT SKU from intranet.dbo.Certification_Products where ID = $skuID");
$sku = odbc_result($skuResult, 1);
//create folder to upload to
mkdir('../uploads/'.$sku.'',0777);
$target_dir = "../uploads/$sku/";
//location is slightly different bc it's used to open the doc from the sku.php page
$location = "uploads/$sku/".$_FILES['file']['name'];
//move file - check if completed successfully
if(move_uploaded_file($_FILES['file']['tmp_name'],  $target_dir. $_FILES['file']['name']))
{
	//update db with location & name of file
	$result = $SQL->SQLQuery("UPDATE intranet.dbo.Certification_LKNorms SET CertLocation = '$location' WHERE FK_NormID = $normID and FK_ProductID = $skuID");

	//check if successful - return outcome
	$checkResult = $SQL->SQLQuery("SELECT * from intranet.dbo.Certification_LKNorms where CertLocation = '".$location."'");

	if(odbc_num_rows($checkResult) > 0)
	{
		echo "success";
	} else
	{
		echo "unsuccessful";
	}

} else 
{
	echo "failed";
}

?>