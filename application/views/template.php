<html>
	<head>
		<title>Tebak Lagu</title>
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/960.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/text.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" />
		<script src="<?php echo base_url('js/jquery-1.7.2.min.js'); ?>"></script>
		<script>
			//buat smooth
			$(document).ready(function(){ 
				$('body').animate({opacity: 1.0}, 1000, function() {}).slideDown();;
				//$("#loading").hide();
			});
		</script>
	</head>
	<body style="opacity:0">
	<div id="menu">
		<div><a href="<?php echo base_url(); ?>"><image src="<?php echo base_url('images/appbar.home.png'); ?>" title="Beranda" class="button"></a></div>
		<div><a href="<?php echo base_url('index.php/klasemen'); ?>"><image src="<?php echo base_url('images/appbar.leaderboard.png'); ?>" title="Klasemen" class="button"></a></div>
		<?php if($user !== NULL): ?>
			<div><a href="<?php echo base_url('index.php/tebak'); ?>"><image src="<?php echo base_url('images/appbar.music.png'); ?>" title="Musik" class="button"></a></div>
			<div><a href="<?php echo base_url('index.php/user/edit'); ?>"><image src="<?php echo base_url('images/appbar.people.png'); ?>"  title="Edit Profil" class="button"></a></div>
			<div><a href="<?php echo base_url('index.php/user/logout'); ?>"><image src="<?php echo base_url('images/appbar.people.arrow.right.png'); ?>" title="Logout" class="button"></a></div>
			<?php if($user['auth'] == 255): ?>
				<div><a href="<?php echo base_url('index.php/administrator/main'); ?>"><image src="<?php echo base_url('images/appbar.tools.png'); ?>" title="Admin" class="button"></a></div>
			<?php endif; ?>
		<?php else: ?>
			<div><a href="<?php echo base_url('index.php/user/login'); ?>"><image src="<?php echo base_url('images/appbar.key.old.png'); ?>" title="Login" class="button"></a></div>
			<div><a href="<?php echo base_url('index.php/user/register'); ?>"><image src="<?php echo base_url('images/appbar.group.add.png'); ?>" title="Register" class="button"></a></div>
		<?php endif; ?>
	</div>
	<div id="wrap" class="container_16">
		<div id="header" class="grid_16">
			
		</div>
		<div id="right">
			<div class="clear"></div>
			<?php echo $konten; ?>
		</div>
		
	</div>
	</body>
</html>