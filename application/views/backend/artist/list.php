<?php
	//Definisikan link2
	$link_sebelumnya = base_url();
	$link_selanjutnya = base_url();
	$link_hapus = base_url('index.php/administrator/artist/hapus');
	$link_edit = 'index.php/administrator/artist/edit/';
	$link_list = base_url('index.php/administrator/artist/lists');
	$link_hapus_semua = base_url('index.php/administrator/artist/hapus_semua');
	$link_tambah = base_url('index.php/administrator/artist/tambah');
?>

<table class="lists" id="table_list" style="display: none">
	<colgroup>
       <col span="1" style="width: 10%;">
       <col span="1" style="width: 45%;">
       <col span="1" style="width: 25%;">
	   <col span="1" style="width: 20%;">
    </colgroup>
	<tr>
		<th>
			Id
		</th>
		<th>
			Nama Artist
		</th>
		<th></th>
	</tr>
	<?php if($rows !== NULL): ?>
	<?php foreach($rows as $row): ?>
		<tr>
			<td>
				<?php echo $row['id']; ?>
			</td>
			<td>
				<?php if($row['nama'] === NULL) : ?>
					???
				<?php else: ?>
					<?php echo $row['nama']; ?>
				<?php endif; ?>
			</td>
			<td>
				<a href="#" onClick="aksi_load('<?php echo base_url($link_edit . $row['id']); ?>')" class="button small">edit</a> 
				<a href="#" onClick="hapus_item('<?php echo $row['id']; ?>', this, '<?php echo $link_hapus ?>')" class="button small">hapus</a> 
			</td>
		</tr>
	<?php endforeach; ?>
	<?php else: ?>
		<tr>
			<td colspan="3">
				Tidak ada artist
			</td>
		</tr>
	<?php endif; ?>
	<tr style="border: none; ">
		<td colspan="3">
			
			<div style="float: left;margin-top: 10px;">
				
				<!-- Link Tambah & Hapus Semua -->
				<a href="#" onClick="aksi_load('<?php echo $link_tambah; ?>')" class="button">
					tambah
				</a>
				<?php if($rows !== NULL): ?>
				<a href="#" onClick="hapus_semua('<?php echo $link_hapus_semua; ?>', this, '<?php echo $link_list; ?>')" class="button">hapus semua</a>
				<?php endif; ?>
				<?php if($total_hal > 1): ?>
				<!-- Link Halaman -->
				<?php if($page_num != 1): ?>
					<a href="#" onClick="list_load('<?php echo $link_list . '/' . ($page_num - 1); ?>')" class="button">Sebelumnya</a>
				<?php endif; ?>
				<span id="kustom_page" style="display: none;">
					<input type="text" name="page" id="page_num" class="small_input" size="1" placeholder="hal" value="<?php echo $page_num; ?>"> / <?php echo $total_hal; ?>
					<a href="#" onClick="goto_custom_page('<?php echo $link_list; ?>')" class="button">Go</a>
				</span>
				<a href="#" onClick="toggle_page_button(this)" class="button">?</a>
				<?php if($page_num != $total_hal): ?>
					<a href="#" onClick="list_load('<?php echo $link_list . '/' . ($page_num + 1); ?>')" class="button">Selanjutnya</a>
				<?php endif; ?>
				<?php endif; ?>
				
				
			</div>
			
		</td>
	</tr>
</table>