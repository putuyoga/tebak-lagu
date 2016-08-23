
$("#form_tambah").submit(function(event) {
	var url = $('#form_tambah #url_tambah').val();
	/* stop form from submitting normally */
	event.preventDefault();
	
	/* set try post Chat */

	
	/* get some values from elements on the page: */
	var data_post = $( this ).serialize();
	
	
	$("#submit_tambah").prop('disabled', true);
	$("#submit_tambah").addClass('buttonDisabled');
	
	/* Send the data using post */
	var posting = $.post( url, data_post, function(data){
		
		if(data.sukses == true) {
			alert("Sukses tambah item baru.");
			//reset isi form
			$("#form_tambah")[0].reset()
			$("#submit_tambah").removeClass('buttonDisabled');
			var url_list = $('#form_tambah #url_list').val();
			list_load(url_list);
		} else {
			alert(data.error);
			$("#submit_tambah").prop('disabled', false);
			$("#submit_tambah").removeClass('buttonDisabled');
		}
	}, 'json');
  
});

$("#search").searchable();
//sedikit modifikasi :P
$("#search").attr("style", "text-decoration: none; width: 310px;");
$('#search').next().css('width', '310px');
$('#search').next().css('padding', '10px');