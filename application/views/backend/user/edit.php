<?php
	$link_list = base_url('index.php/administrator/users/lists/');
	$link_upload = base_url('index.php/administrator/users/upload/' . $id);
	$link_edit = base_url('index.php/administrator/users/edit_ajax');
	$link_reset = base_url('index.php/administrator/users/reset_password');
?>

<form id="form_edit">
	<input type="hidden" name="id" value="<?php echo $id; ?>">
	<input type="hidden" value="<?php echo $link_list; ?>" id="url_list">
	<input type="hidden" value="<?php echo $link_edit; ?>" id="url_edit">
	<table id="table_aksi" style="display: none;">
		<tr>
			<td>
				<input type="text" name="username" placeholder="Masukkan Username" value="<?php echo $username; ?>">
			</td>
		</tr>
		<tr>
			<td>
				<input type="text" name="email" placeholder="Masukkan Email" value="<?php echo $email; ?>">
			</td>
		</tr>
		<tr>
			<td>
				<?php
					echo form_dropdown('auth', get_auth_array(), $auth);
				?>
			</td>
		</tr>
		<tr>
			<td>
				Tgl Bergabung <?php echo date('d M Y', strtotime($joinDate)); ?>
			</td>
		</tr>
		<tr>
			<td>
				<a href="#" onClick="do_reset('<?php echo $id; ?>', '<?php echo $link_reset; ?>')" class="button" id="tombol_reset">Reset Password</a> <input type="text" id="reset_password" style="width: auto; margin-left: auto; margin-right: auto;" disabled>
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