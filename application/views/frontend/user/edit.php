<?php 
	$url_ajax = base_url('index.php/user/edit/ajax');
?>
<div class="grid_8">
	<form id="form_edit">
	<input type="hidden" id="url_ajax" value="<?php echo $url_ajax; ?>">
	<table style="width: 400px;margin-left: auto; margin-right: auto">
		<tr>
			<td>
				<input type="email" name="email" placeholder="Masukkan Email" value="<?php echo $email; ?>">
			</td>
		</tr>
		<tr>
			<td>
				<input type="password" name="password" placeholder="Masukkan Password">
				<br/>
				<small style="color: red;">*biarkan kosong, jika tidak ingin ganti</small>
			</td>
		</tr>
		<tr>
			<td>
				<input type="password" name="re_password" placeholder="Ketik Ulang Password">
			</td>
		</tr>
		<tr>
			<td style="align: center; ">
				<input type="submit" id="submit_edit" class="button" style="width: 100%" value="Perbarui" />
			</td>
		</tr>
	</table>
	</form>
</div>
<div class="grid_8 judul">
	<h1>Edit Profil</h1>
</div>

<script>
$('#form_edit').submit(function(event) {
	
	var url = $('#form_edit #url_ajax').val();
	
	/* stop form from submitting normally */
	event.preventDefault();
	
	/* get some values from elements on the page: */
	var data_post = $( this ).serialize();
	
	//disabled tombolnya
	$("#submit_edit").prop('disabled', true);
	$("#submit_edit").addClass('buttonDisabled');
	
	/* Send the data using post */
	var posting = $.post( url, data_post, function(data){
		if(data.sukses == true) {
			alert('Berhasil perbarui informasi anda.');
			console.log('Berhasil edit');
		} else {
			alert(data.error);
		}
		//enable lagi tombolnya
		$("#submit_edit").prop('disabled', false);
		$("#submit_edit").removeClass('buttonDisabled');
	}, 'json');
  
});
</script>