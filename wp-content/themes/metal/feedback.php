<?php
	/*Template Name: Contact form*/
?>
<?php global $SMTheme;?>
<?php
	if (isset($_POST[$_SESSION['commentinput']])&&$form=$_POST[$_SESSION['commentinput']]) {
		$msg='';
		$error='';
		$errorcode='red';
		foreach ($SMTheme->get( 'contactform', 'contactform' ) as $key=>$detail) {
			if ($detail['req']=='required'&&$form[$key]=='') $error.='Field '.$detail['ttl']." is required<br />";
			if ($detail['regex']!=''&&!preg_match('/'.stripslashes($detail['regex']).'/',$form[$key])) {
				$error.='Field '.$detail['ttl']." is not valid<br />";
			}
			$msg.=$detail['ttl'].": ".$form[$key]."\r\n";
		}
		$from=($SMTheme->get( 'general','sitename' ))?$SMTheme->get( 'general','sitename' ):get_bloginfo('name');
		if ($error=='') {
			wp_mail($SMTheme->get( 'contactform', 'email' ), 'Message from '.$from, $msg);
			$error=$SMTheme->_( 'emailok' );
			$errorcode='green';
		}
	}		
?>
<?php
	get_header();
?>
<div class='articles'>
	<?php
	the_post(); 
	?>
		<div class='one-post'>
		<div id="post-<?php the_ID(); ?>" <?php post_class("post-caption"); ?>>
			<?php if (!is_single()&&!is_page()) { ?>
			<h2><a href="<?php the_permalink(); ?>" title="<?php printf( $SMTheme->_( 'permalink' ), the_title_attribute( 'echo=0' ) ); ?>" class='post_ttl'><?php the_title(); ?></a></h2>
			<?php } else { ?>
				<h1><?php the_title(); ?></h1>
			<?php } ?>
		</div>
		<div class='post-body'>
			<?php
				the_content('');
            ?>
		
		<?php if ( $SMTheme->get( 'contactform','address' ) != '' ) {?>
		<div class='googlemap waiting'><div id="map_canvas" style="width: 100%; height: 300px;"></div></div>
		
		<script>jQuery(function(){loadGMap('<?php echo $SMTheme->get( 'contactform','address' )?>', 'map_canvas', 16)});</script>

		<?php } ?>
<?php echo ($error!='')?"<p style='color:".$errorcode."'>".$error."</p>":''?>
<?php
	if ($SMTheme->get( 'contactform', 'email' )) {
?>
<form action='' method='POST' class='feedback'>
<h3><?php echo $SMTheme->_( 'feedbackttl' ); ?></h3>
<i><?php echo $SMTheme->_( 'feedbackbefore' ); ?></i>
	<?php
		foreach ($SMTheme->get( 'contactform', 'contactform' ) as $key=>$detail) {
			switch ($detail['type']) {
				case 'text':
				?>
<p><?php echo $detail['ttl']?>: <?php echo ($detail['req']=='required')?'(*)':''?>
<div class='input'><input type='text' value='' name='<?php echo $key?>'<?php echo ($detail['req']=='required')?" required='true'":''?> /></div>
</p>
				<?php
				break;
				case 'textarea':
				?>
<p><?php echo $detail['ttl']?>: <?php echo ($detail['req']=='required')?'(*)':''?>
<div class='input'><textarea rows='5' name='<?php echo $key?>'<?php echo ($detail['req']=='required')?" required='true'":''?>></textarea></div>
</p>
				<?php
				break;
			}
		}
	?>

<center><input type='submit' class='readmore' value='<?php echo $SMTheme->_( 'send' );?>' /></center>
</form>
<?php } ?>
<?php if ($SMTheme->get( 'contactform','text' )) { ?>
<div style='margin-bottom:20px;'>
<?php echo $SMTheme->get( 'contactform','text' )?>
</div>
<?php } 

	$details=$SMTheme->get( 'contactform', 'details' );
	if (!empty($details)) {
?>
<ul class='contact-details'>
	<?php
		foreach ($details as $key=>$detail) {
		?>
			<li class='contact<?php echo $key?>'><?php echo $detail['content']?></li>
		<?php
		}
	?>
</ul>
<style>
					<?php
						foreach ($SMTheme->get( 'contactform', 'details' ) as $key=>$detail) {
						?>
					ul.contact-details li.contact<?php echo $key?> {
						background:url(<?php echo $detail['img']?>) left top no-repeat;
					}
						<?php
						}
					?>
				</style>
<?php } else { ?>
	<style>
		form.feedback { width:100%;	}
	</style>
<?php	
	}
?>
</div>
		</div>
 </div>
 <script>
	jQuery('.feedback input').each(function(){
		jQuery(this).attr('name','<?php echo $_SESSION['commentinput']; ?>['+jQuery(this).attr('name')+']');
	});
	jQuery('.feedback textarea').each(function(){
		jQuery(this).attr('name','<?php echo $_SESSION['commentinput']; ?>['+jQuery(this).attr('name')+']');
	});
 </script>
<?php
	get_footer();
?>