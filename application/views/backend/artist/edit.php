<?php
	$link_list = base_url('index.php/administrator/artist/lists/');
	$link_upload = base_url('index.php/administrator/artist/upload/' . $id);
	$link_edit = base_url('index.php/administrator/artist/edit_ajax');
?>

<form id="form_edit">
	<input type="hidden" name="id" value="<?php echo $id; ?>">
	<input type="hidden" value="<?php echo $link_list; ?>" id="url_list">
	<input type="hidden" value="<?php echo $link_edit; ?>" id="url_edit">
	<table id="table_aksi" style="display: none;">
		<tr>
			<td>
				<input type="text" name="nama" placeholder="Masukkan Nama Artist" value="<?php echo $nama; ?>">
			</td>
		</tr>
		<tr>
			<td style="align: center; ">
				<input type="submit" id="submit_edit" class="button" style="width: 100%" value="Perbarui" />
			</td>
		</tr>
	</table>
</form>

<script src="<?php echo base_url('js/edit.js'); ?>"></script>