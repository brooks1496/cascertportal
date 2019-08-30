<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php
include('includes/auth.php');



?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#save').on('click', function(){
			var certs = [];
			var sku = $('#code').text();
			var sid = $('#sid').text();
			$('.certificationCheckbox:checked').each(function(){
				certs.push(this.value);
			});
			if(certs.length > 0){
				$.post('posts/postToSession.php', {certs:certs, sku:sku, sid:sid}).done(function(data){
					console.log(data);

					if(data == 'success'){
						$('#result').html('Successfully updated');
					} else {

					}
				})
			}
		})
	})
</script>
<table>

	<?php 
$result = $SQL->SQLQuery('SELECT * from intranet.dbo.Certification_Certificates');

while($rows = odbc_fetch_object($result)){
	
	echo "<tr><th>$rows->Certificate</th><td><input type='checkbox' value='$rows->ID' class='certificationCheckbox'></td></tr>";
	
}

?>
</table>
<div id="result"></div>
<input type="button" value="Save Certifications" id="save"><p style="display: none;" id="code"><?php echo $_REQUEST['sku']; ?></p><p style="display: none;" id="sid"><?php echo $_REQUEST['sid']; ?></p>

