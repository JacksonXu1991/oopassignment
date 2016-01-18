$(document).ready(function(){ 
$("#upload").change(function () {
	//alert(\'nima\');  
	$.ajaxFileUpload({
		url: 'http://127.0.0.1:8080/oopassignment/web/back/upload',
		secureuri: false,
		data:{'id':'upload'},
		fileElementId:'upload',
		dataType: 'json',
		success: function (data, status) {
			if( data["result"] == 'Success' ) {
				alert("success");
				} else{
					alert("fail");
					}
					},
					error: function (data, status, e) {return;}});}); 
					$("#auploads").click(  function(){ 
					$("#upload").click();});
					//$("#upload").on("change", function () {
					//	alert('live'); 
					//	$.ajaxFileUpload(config); 
					//	$("#upload").replaceWith('<input type="file" id="upload" name="UploadForm[file]" ></input>');});
					}); 
        