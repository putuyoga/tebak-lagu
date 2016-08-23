<div class="grid_8" style="text-align: center;">
<?php $on_top = FALSE; $i = 0; ?>
<?php if($rows !== FALSE): ?>
	<?php foreach($rows as $row): ?>
		<?php $i++; ?>
		<?php if($row['id_user'] === $current_user['id']): ?>
			<?php $on_top = TRUE; ?>
			<div class="sel_klasemen_user">
				<div style="float: right; font-size: 20px" class="button"><?php echo $i; ?></div>
				<div style="float: right; text-align: right; margin-right: 10px;"><?php echo $row['username']; ?><br/><small><?php echo $row['nilai']; ?> poin </small></div>
			</div>
		<?php else: ?>
			<div class="sel_klasemen">
				<div style="float: right; font-size: 20px" class="button"><?php echo $i; ?></div>
				<div style="float: right; text-align: right; margin-right: 10px;"><?php echo $row['username']; ?><br/><small><?php echo $row['nilai']; ?> poin </small></div>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>
	<?php if($on_top === FALSE && $current_user['id'] !== NULL): ?>
		<div class="sel_klasemen_user">
				<div style="float: right; font-size: 20px" class="button">?</div>
				<div style="float: right; text-align: right; margin-right: 10px;"><?php echo $current_user['username']; ?><br/><small><?php echo $current_user['nilai']; ?> poin </small></div>
			</div>
	<?php endif; ?>
<?php else: ?>
	<div class="sel_klasemen">Belum ada yang main :(</div>
<?php endif; ?>
</div>
<div class="grid_8 judul">
	<h1>Klasemen</h1>
</div>