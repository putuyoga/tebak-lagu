<?php
	$link_list = base_url('index.php/administrator/lagu/lists/');
	$link_upload = base_url('index.php/administrator/lagu/upload/' . $id);
	$link_edit = base_url('index.php/administrator/lagu/edit_ajax');
?>

<form id="form_edit">
	<input type="hidden" name="id" value="<?php echo $id; ?>">
	<input type="hidden" value="<?php echo $link_list; ?>" id="url_list">
	<input type="hidden" value="<?php echo $link_edit; ?>" id="url_edit">
	<table id="table_aksi" style="display: none;">
		<tr>
			<td>
				<input type="text" name="judul" placeholder="Masukkan Judul Lagu" value="<?php echo $judul; ?>">
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $dropdown; ?>
			</td>
		</tr>
		<tr>
			<td style="align: center; ">
				<input type="submit" id="submit_edit" class="button" style="width: 100%" value="Perbarui" />
			</td>
		</tr>
	</table>
</form>
<form id="form_lagu" action="<?php echo $link_upload; ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?php echo $id; ?>">
	<input type="hidden" name="url" id="url_lagu" value="<?php echo base_url('lagu/' . $id . '.ogg'); ?>">
	<table>
		<tr>
			<td><input type="file" name="lagu" id="lagu" /></td>
		</tr>
		<tr>
			<td style="align: center; ">
				<input type="submit" id="submit_lagu" class="button" style="width: 100%" value="Upload" />
			</td>
		</tr>
		<tr>
			<td>
				<div class="progress">
					<div class="bar"></div >
					<div class="percent">0%</div>
				</div>
				<div id="status"></div>
			</td>
		</tr>
		<tr>
			<td id="lagu_container">
				<?php if(file_exists('lagu/' . $id . '.ogg') !== FALSE): ?>
				<audio id="lagu_player" style="width: 100%;" controls>
					<source id="source_lagu" src="<?php echo base_url("lagu/$id.ogg"); ?>" type="audio/ogg">
				</audio>
				<?php else: ?>
					Belum ada file lagu
				<?php endif; ?>

			</td>
		</tr>
	</table>
</form>
<script src="<?php echo base_url('js/jquery.searchabledropdown-1.0.8.min.js'); ?>"></script>
<script src="<?php echo base_url('js/edit.js'); ?>"></script>
<!-- Upload lagu handler -->
<script src="<?php echo base_url('js/jquery.form.js'); ?>"></script>	
<script src="<?php echo base_url('js/upload.js'); ?>"></script>