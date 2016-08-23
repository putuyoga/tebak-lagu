<?php
	$url_lagu = base_url('index.php/tebak/lagu');
	$url_mulai = base_url('index.php/tebak/mulai_ajax');
	$url_input = base_url('index.php/tebak/input');
	$url_hasil = base_url('index.php/tebak/selesai_ajax');
	$url_klasemen = base_url('index.php/klasemen');
?>

<div id="hasil" style="display: none; text-align: center;">
	<div style="width: 360px; margin-left: auto; margin-right: auto; margin-top: 10px; text-align: center;">
		<div style="float: left;">
			<div class="button" style="width: 100px; height: 60px;" onClick="window.location.replace('<?php echo $url_klasemen; ?>');"><span style="font-size: 30px;"><?php echo $skor_sebelum; ?></span>pt<br/><small>Sebelum</small></div>
		</div>
		<div style="float: left;">
			<div class="button" style="width: 100px; height: 60px;" onClick="mulai_tebak('<?php echo $url_mulai; ?>','<?php echo $url_lagu; ?>', '<?php echo $url_input; ?>');"><span style="font-size: 15px;">Coba Lagi</span><br/><small>buat rekor baru !</small></div>
		</div>
		<div style="float: left;">
			<div class="button" style="width: 100px; height: 60px;" onClick="window.location.replace('<?php echo $url_klasemen; ?>');"><span style="font-size: 30px;"><?php echo $skor_setelah; ?></span>pt<br/><small>Sekarang</small></div>
		</div>
			<?php if($tamat == TRUE): ?>
				<div>Selamat, anda sudah menebak semua lagu di database ! Tunggu update dari kami ;)</div>
			<?php elseif($new_highscore === TRUE): ?>
				<div>Selamat <?php echo $username; ?>! Anda berhasil mengalahkan rekor skor anda sebelumnya !</div>
			<?php else: ?>
				<div>Maaf <?php echo $username; ?>, anda gagal mengalahkan rekor sebelumnya :(</div>
			<?php endif; ?>
	</div>
</div>