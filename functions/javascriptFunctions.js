function setDropzone (title, uploadUrl, defaultMessage){
	$('#'+title).dropzone({ 

		url:'defaultURL/test',
		
		clickable: true,
		createImageThumbnails: true,
		thumbnailWidth: 120,
    	thumbnailHeight: 120,
		init:function(){

			this.on("addedfile", function(file, responseText){
				this.options.url = uploadUrl;
				alert(responseText);
			});
			
			this.on("queuecomplete", function(file) { 
				
				
				location.reload();

			});
		}

	});
	$('#'+title).find("span").html(defaultMessage);
}

function setDropzoneNoOnClick (title, uploadUrl, defaultMessage){
	$('#'+title).dropzone({ 

		url:'defaultURL/test',
		
		clickable: false,
		createImageThumbnails: true,
		thumbnailWidth: 120,
    	thumbnailHeight: 120,
		init:function(){

			this.on("addedfile", function(file, responseText){
				this.options.url = uploadUrl;
				alert(responseText);
			});
			
			this.on("queuecomplete", function(file) { 
				
				
				location.reload();

			});
		}

	});
	$('#'+title).find("span").html(defaultMessage);
}