<?php
	//Definisikan link2
	$link_hapus = base_url('index.php/administrator/skor/hapus');
	$link_list = base_url('index.php/administrator/skor/lists');
	$link_hapus_semua = base_url('index.php/administrator/skor/hapus_semua');
?>

<table class="lists" id="table_list" style="display: none">
	<colgroup>
       <col span="1" style="width: 80%;">
       <col span="1" style="width: 15%;">
    </colgroup>
	<tr>
		<th>
			Username
		</th>
		<th>
			Poin
		</th>
		<th></th>
	</tr>
	<?php if($rows !== NULL): ?>
	<?php foreach($rows as $row): ?>
		<tr>
			<td>
				<?php echo $row['username']; ?>
			</td>
			<td>
				<?php echo $row['nilai']; ?>
			</td>
			<td>
				<a href="#" onClick="hapus_item('<?php echo $row['id']; ?>', this, '<?php echo $link_hapus ?>')" class="button small">hapus</a> 
			</td>
		</tr>
	<?php endforeach; ?>
	<?php else: ?>
		<tr>
			<td colspan="3">
				Tidak ada skor
			</td>
		</tr>
	<?php endif; ?>
	<tr style="border: none; ">
		<td colspan="3">
			
			<div style="float: left;margin-top: 10px;">
				
				<!-- Link Hapus Semua -->
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