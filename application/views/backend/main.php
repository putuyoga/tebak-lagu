<div id="lists" class="grid_10"></div>
<div id="aksi" class="grid_6"></div>
<div class="clear"></div>
<div class="grid_16" style="margin-top: 50px;">
	<a href="#" onClick="list_load('<?php echo base_url('index.php/administrator/lagu/lists'); ?>')" class="button">
		Lagu
	</a>
	<a href="#" onClick="list_load('<?php echo base_url('index.php/administrator/artist/lists'); ?>')" class="button">
		Artist
	</a>
	<a href="#" onClick="list_load('<?php echo base_url('index.php/administrator/users/lists'); ?>')" class="button">
		User
	</a>
	<a href="#" onClick="list_load('<?php echo base_url('index.php/administrator/skor/lists'); ?>')" class="button">
		Skor
	</a>
</div>
<!-- Fungsi-fungsi JS -->
<script src="<?php echo base_url('js/lib.js'); ?>"></script>
<script>
	//load dulu
	list_load('<?php echo base_url('index.php/administrator/lagu/lists'); ?>');
</script>