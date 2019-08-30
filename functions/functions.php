<?php 

$GLOBALS['var'] = "succ";

class conn
{
	private $odbc_name = "Inventory";
	private $user_name = "web_access";
	private $password = "Sys314169$";
	public $con; 
	function __construct (){
		$this->con = odbc_connect($this->odbc_name,$this->user_name,$this->password) or die('Could not connect to the server!');
	}

}

class SQLClass extends conn
{

	private $SQL;
	private $result;

	public function SQLQuery($arg1){
		$this->SQL = $arg1;

		$this->result = odbc_exec($this->con, $this->SQL);
		return $this->result;
	}
	
}

class SKUFunc extends conn
{	
	public $SQL;
	public $result;
	public $checkRes;
	public $supplier;
	public $table;

	function checkSKUinDB($sku){
		$this->SQL = "SELECT * from intranet.dbo.Certification_Products where SKU = '$sku'";
		$this->result = odbc_exec($this->con, $this->SQL);

		if(odbc_num_rows($this->result) > 1){
			$this->checkRes = 2;
		} else if (odbc_num_rows($this->result) == 1) {
			$this->checkRes = 1;
		} else {
			$this->checkRes = 0;
		}
		
		return $this->checkRes;
	}

	function searchSKU($sku){
		if($this->checkRes == 2){
			$this->SQL = "SELECT * from intranet.dbo.Certification_Products where SKU = '$sku'";
			$this->result = odbc_exec($this->con, $this->SQL);
			$this->table = "<table class='table table-hover'>";
			while($this->rows = odbc_fetch_object($this->result)){
				$this->table .= "<tr class='clickable-row' data-href='sku.php?sku=".$this->rows->SKU."&supp=".$this->rows->Supplier."'><th>".$this->rows->SKU." - ".$this->rows->Supplier."<th></tr><tr></tr>";
			}
			$this->table .= "</table>";

			echo $this->table;
		} else if($this->checkRes == 1){
			$this->SQL = "SELECT * from intranet.dbo.Certification_Products where SKU = '$sku'";
			$this->result = odbc_exec($this->con, $this->SQL);
			$this->supplier = odbc_result($this->result, 6);

			header("location: sku.php?sku=".$sku."&supp=".$this->supplier);
		} else {
			$this->table = "<table class='table table-hover'><tr class='clickable-row' data-href='skulist.php?sku=".$sku."'><th>No SKU's Found - Click here to search in the unadded queue</th></tr></table>";
			echo $this->table;
		}
	}

	function updateSKU($skuID, $column, $input){
		$this->SQL = "UPDATE Intranet.dbo.Certification_Products SET $column = '$input' where ID = $skuID";
		$this->result = odbc_exec($this->con, $this->SQL);

		if($this->result){
			return "success";
		} else {
			return "failed";
		}
	}

	function getSKUCerts($skuID)
	{
		$this->SQL = "  SELECT * from intranet.dbo.Certification_LKCert lk
  						inner join Intranet.dbo.Certification_Certificates cc on lk.FK_CertificationID = cc.ID where FK_ProductID = $skuID";
		$this->result = odbc_exec($this->con, $this->SQL);
		return $this->result;

	}

	function updateSKUCerts($skuID, $certID, $certified, $certNum, $expiry){
		$this->SQL = "UPDATE intranet.dbo.Certification_LKCert SET Required = '$certified', certNumber = '$certNum', ExpiryDate = '$expiry' WHERE FK_ProductID = $skuID AND FK_CertificationID = $certID";
		$this->result = odbc_exec($this->con, $this->SQL);

		if($this->result){
			return "success";
		} else {
			return "failed";
		}
	}

	function checkSKUImage($skuID){
		$this->SQL = "SELECT * from intranet.dbo.Certification_Images where FK_ProductID = $skuID";
		$this->result = odbc_exec($this->con, $this->SQL);

		if(odbc_num_rows($this->result) > 0){
			return odbc_result($this->result, 3);
		} else {
			return "No Image Found";
		}
	}
	function setDropzone($skuID, $sku, $img){
		$this->SQL = "SELECT * from intranet.dbo.Certification_Images where FK_ProductID = $skuID";
		$this->result = odbc_exec($this->con, $this->SQL);
		
		if(odbc_num_rows($this->result) < 1){
			$this->dropzone = '
			<div class="col-md-4">
				<div class="container" id="dropTbl">
					<div class="dropzone" id="imgDrop">
				
					</div>
				</div>
			</div>';
		} else {
			$this->url = "SKUimages/$sku/$img";
			$this->dropzone = 
			"<div class=col-md-4>
				<div class='container' id='dropTbl'>
					<div class='dropzone' id='imgDropNoClick' style='background-size: cover; background-image: url(".$this->url."?".filemtime("$this->url").")'>
				
					</div>
				</div>
			</div>";

		}
		return $this->dropzone;
	}
	function uploadImageDetails($skuID, $filename)
	{
		$this->SQL = "insert into intranet.dbo.certification_images VALUES ($skuID, '$filename')";
		$this->result = odbc_exec($this->con, $this->SQL);
	}
	function updateImageDetails($skuID, $filename)
	{
		$this->SQL = "UPDATE intranet.dbo.certification_images set ImageURL = '$filename' where FK_ProductID = $skuID";
		$this->result = odbc_exec($this->con, $this->SQL);
	}

	function getNorms($skuID)
	{
		$this->SQL = "SELECT * from intranet.dbo.Certification_LKNorms lkn
inner join intranet.dbo.Certification_Norms cn on lkn.FK_NormID = cn.ID where FK_ProductID = $skuID";
		$this->result = odbc_exec($this->con, $this->SQL);
		return $this->result;
	}

}



?>