
/**
	Form edit ini digunakan untuk mengirimkan data
	yang digunakan untuk melakukan update/edit
	suatu data
**/
function do_reset(id_user, url)
{
	//Disabled button, biar user ga klik 2x
	$("#tombol_reset").prop('disabled', true);
	$("#tombol_reset").addClass('buttonDisabled');
	  
	//Proses post data dari form!
	var posting = $.get( url+'/'+id_user, function(data){
		//jika sukses
		if(data.sukses == true) {
			$('#reset_password').val(data.password_baru);
		} else {
			alert(data.error);
		}
		//Enable button, karena proses post sudah selesai.
		$("#tombol_reset").prop('disabled', false);
		$("#tombol_reset").removeClass('buttonDisabled');
	}, 'json');
  
}
$("#form_edit").submit(function(event) {
	//ambil url edit dari input form
	var url = $('#form_edit #url_edit').val();
	
	//batalkan submit, selanjutnya kita proses via ajax !
	event.preventDefault();
	
	/* get some values from elements on the page: */
	var data_post = $( this ).serialize();
	
	//Disabled button, biar user ga klik 2x
	$("#submit_edit").prop('disabled', true);
	$("#submit_edit").addClass('buttonDisabled');
	  
	//Proses post data dari form!
	var posting = $.post( url, data_post, function(data){
		//jika sukses
		if(data.sukses == true) {
			alert('Sukses edit item !');
			//load ulang list
			var url_list = $('#form_edit #url_list').val();
			list_load(url_list);
		} else {
			alert(data.error);
		}
		//Enable button, karena proses post sudah selesai.
		$("#submit_edit").prop('disabled', false);
		$("#submit_edit").removeClass('buttonDisabled');
	}, 'json');
  
});

$("#search").searchable();
//sedikit modifikasi :P
$("#search").attr("style", "text-decoration: none; width: 310px;");
$('#search').next().css('width', '310px');
$('#search').next().css('padding', '10px');