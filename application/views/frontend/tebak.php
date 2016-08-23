<?php
	$url_lagu = base_url('index.php/tebak/lagu?_s=' . md5(microtime()-rand(1,100)));
	$url_mulai = base_url('index.php/tebak/mulai_ajax');
	$url_input = base_url('index.php/tebak/input');
	$url_hasil = base_url('index.php/tebak/selesai_ajax');
	$url_benar = base_url('sounds/benar.ogg');
	$url_salah = base_url('sounds/salah.ogg');
?>
<input type="hidden" value="<?php echo $url_hasil; ?>" id="url_hasil">
<div id="timer_container" class="grid_16" style="text-align: center; ">
	<input type="text" class="timer" data-min="0" data-max="30" value="30" data-thickness=".4" data-fgColor="#232323" data-readOnly=true>
</div>
<div class="clear"></div>
<div id="tebak_container" class="grid_16" style="text-align: center; ">
	<p>Tiap lagu hanya diberi 30 detik untuk menebak.</p><br/>
	<a href="#" onClick="mulai_tebak('<?php echo $url_mulai; ?>','<?php echo $url_lagu; ?>', '<?php echo $url_input; ?>');" class="button full_besar">Mulai</a>
</div>
<div class="clear"></div>
<div id="input_container" class="grid_16" style="text-align: center;">
</div>
<audio style="display: none;" id="benar" style="width: 400px;" controls><source id="source_lagu" src="<?php echo $url_benar; ?>" type="audio/ogg"></audio>
<audio style="display: none;" id="salah" style="width: 400px;" controls><source id="source_lagu" src="<?php echo $url_salah; ?>" type="audio/ogg"></audio>
<!-- Fungsi-fungsi JS -->
<script src="<?php echo base_url('js/tebak.js'); ?>"></script>
<script src="<?php echo base_url('js/jquery.knob.js'); ?>"></script>
<script>
$(function() {
    $(".timer").knob();
});
</script>