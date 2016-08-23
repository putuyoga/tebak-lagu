/**
	Digunakan untuk handle upload file lagu
	yang nantinya format harus .ogg
**/
$(':file').change(function(){
    var file = this.files[0];
    size = file.size;
    type = file.type;
    //your validation
	if(type != 'audio/ogg')
	{
		alert('hanya boleh file ogg !');
		var control = $( this );
		control.replaceWith( control = control.clone( true ) );
	}
});

/**
	Untuk upload lagu dengan ajax
**/
$(document).ready(function() {
    
var bar = $('.bar');
var percent = $('.percent');
var status = $('#status');
   
$('#form_lagu').ajaxForm({
	//kondisi sebelum upload
    beforeSend: function() {
        status.empty();
        var percentVal = '0%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
	//sedang dalam proses upload
    uploadProgress: function(event, position, total, percentComplete) {
        var percentVal = percentComplete + '%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
	//sukses upload
    success: function() {
        var percentVal = '100%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
	//selesai
	complete: function(xhr) {
		var obj = jQuery.parseJSON(xhr.responseText);
		if(obj.sukses == true)
		{
			/*---------------------------------
			replace player dengan yang baru,
			karena file lagu baru telah diupload
			-------------------------------------*/
			var url = $('#url_lagu').val();
			$('#lagu_container').html('<audio id="lagu_player" style="width: 100%;" controls><source id="source_lagu" src="'+url+'" type="audio/ogg"></audio>');
			
			//reset file select
			var control = $(':file');
			control.replaceWith( control = control.clone( true ) );
			
			//tampilkan feedback
			alert('sukses upload lagu !');
		}
		else
		{
			alert(obj.error);
		}
	}
}); 

});