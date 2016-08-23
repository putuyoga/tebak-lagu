<?php
	$link_list = base_url('index.php/administrator/lagu/lists');
	$link_tambah = base_url('index.php/administrator/lagu/tambah_ajax');
?>
<form id="form_tambah">
	<input type="hidden" value="<?php echo $link_list; ?>" id="url_list">
	<input type="hidden" value="<?php echo $link_tambah; ?>" id="url_tambah">
	<table id="table_aksi" style="display: none;">
		<tr>
			<td>
				<input type="text" name="judul" placeholder="Masukkan Judul Lagu">
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $dropdown; ?>
			</td>
		</tr>
		<tr>
			<td style="align: center; ">
				<input type="submit" id="submit_tambah" class="button" style="width: 100%" value="Tambah" /> 
				
			</td>
		</tr>
	</table>
</form>
<script src="<?php echo base_url('js/tambah.js'); ?>"></script>