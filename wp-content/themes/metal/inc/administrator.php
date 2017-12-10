<?php
if ( current_user_can('administrator')&&isset($_GET['restore_footer'])&&$_GET['restore_footer']=='1') {
	unlink(get_template_directory().'/footer.php');
	copy(get_template_directory().'/inc/fbackup.txt',get_template_directory().'/footer.php');
}
class AdminPage {
	var $PageOptions;
	var $tasks;
	var $updateready;
	function AdminPage() {
		global $SMTheme, $pagenow;
		
		
		$this->tasks = array ('imageupload','formsave','zipupload','activate');
		$this->PageOptions=$SMTheme->options;
		if (isset($_GET['page'])&&$_GET['page']!='')
		add_action('admin_head', array(&$this, 'loadHeadTemplate'));
		add_action( 'admin_enqueue_scripts', array(&$this, 'loadHead' ));
		add_action('admin_menu', array(&$this, 'loadMenu'));
		
		add_action('wp_ajax_processing_ajax', array(&$this, 'ajax_callback'));
	}
	
	
	 function loadMenu(){
			$info = wp_get_theme();
			$name = $info['Name']?$info['Name']:'SMT Options';
		  add_menu_page('Theme', $name, 'manage_options', 'OptionsPage', array(&$this, 'ThemeOptionsPage'), '', 64);
		 add_theme_page( $name, $name, 'manage_options', 'OptionsPage', array(&$this, 'ThemeOptionsPage'));
		  $this->load_tabs_menu(1);
	}
	  function loadHeadTemplate()
	{	
		if ($_GET['page']=='OptionsPage')$_GET['page']='general';
		if (is_array($this->PageOptions[$_GET['page']])) {
		?>
		<link rel='stylesheet' href='<?php echo get_template_directory_uri()?>/inc/css/admin.css' type='text/css' media='all' />
		<?php } ?>
		<script type="text/javascript">
			jQuery(function() {
				jQuery('ul.tabs-menu').delegate('li:not(.active)', 'click', function() {
					var s=jQuery(this).addClass('active').siblings().removeClass('active').parents('.tabs-inner').children('ul.tabs-content').children('li').hide().removeClass('active').eq(jQuery(this).index()).fadeIn('slow').addClass('active').attr('id');
					if (s=='updates') {
						if (jQuery("#updatesfrm").html()=='')
						jQuery("<iframe height='720px' width='100%' src='http://smthemes.com/updates/'></iframe>").appendTo("#updatesfrm");
					}
					if (s=='activate'||s=='updates'||s=='contacts') {
						jQuery('#smthemes-btns-float').hide();
						jQuery('.reset_data_btn').hide();
					} else {
						jQuery('#smthemes-btns-float').show();
						jQuery('.reset_data_btn').show();
					}
					jQuery('#adminmenu .wp-has-current-submenu ul li').removeClass('current').eq(jQuery(this).index()+1).addClass('current');
					jQuery('.reset_data_btn').text('Reset '+jQuery(this).text().trim()+' options');
				})
			})
			<?php if ($_GET['page']=='updates') { ?>
			jQuery(document).ready(function() {
				jQuery("<iframe height='720px' width='100%' src='http://smthemes.com/updates/'></iframe>").appendTo("#updatesfrm");
			});
			<?php } ?>
		</script>
<?php
	}
	
	
	function loadHead() {
		
		wp_enqueue_script( 'smt_admin', get_template_directory_uri() . '/js/admin.js' );
		wp_enqueue_script( 'smt_ajaxupload', get_template_directory_uri() . '/js/ajaxupload.js' );
		wp_enqueue_script( 'jquery-ui-sortable' );
	}
	
	
	function ThemeOptionsPage() {
		?>
        <div class="wrap">
			<?php if ($_GET['page']=='updates'||$_GET['page']=='activate'||$_GET['page']=='contacts') {
				$class=' style="display:none"';
			} else {
				$class='';
			} ?>
			<div id='smthemes-btns-float'<?php echo $class; ?>>
				<span class='save_data_btn' title='Save Changes'></span>
				<img class='ajaxloader' src="<?php echo get_template_directory_uri()?>/inc/images/ajax-loader2.gif" alt="Please wait" title="Please wait" />
			</div>
                <?php 
                        $info = get_theme_data(TEMPLATEPATH.'/style.css');
                        $ver = $info['Version']?$info['Version']:'';
						$name = $info['Name']?$info['Name']:'';
                    ?> 
           
         
                
				<div class='smthemes-top'><img src="<?php echo get_template_directory_uri()?>/inc/images/logo.png" alt="SMThemes.com" style='' />
					<span class="tt-themename">
					 <span style='font-size:42pt;color:#999;font-family:arial;'>|</span> <?php echo $name?> | <?php echo $ver?>
					</span>
			</div>
                <div class="tabs">
					<div class='tabs-inner'>
						<ul class="tabs-menu">
							<?php
								$this->load_tabs_menu();
							?>
						</ul>
						
						<ul class="tabs-content">
						<form></form>
							<?php
								$this->load_tabs_content();
							?>
						</ul>
						<div style='clear:both'></div>
					</div>
				</div>
                    
                            <div class='smthemes-btns'><div class='bottom-background'></div>
								<?php
									$_SESSION['reset']=rand();
								?>
								<form action='' method='POST' id='resetform'>
									<input type='hidden' name='reset' value='<?php echo $_SESSION['reset']?>' />
									<input type='hidden' name='option' value='' />
								</form>
								<img class='ajaxloader' src="<?php echo get_template_directory_uri()?>/inc/images/ajax-loader.gif" alt="Please wait" title="Please wait" />
								<img id='imgloader' src="<?php echo get_template_directory_uri()?>/inc/images/img-loader.gif" alt="Please wait" title="Please wait" /><span id='server_answer'></span>
                                <a class="button-primary reset_data_btn">Reset <?php echo $this->PageOptions[$_GET['page']]['name'] ?> options</a>
                            </div>
                        
    
        </div>
    <?php
	}
	
	function load_tabs_menu($type=0) {
		
		if (is_array($this->PageOptions)&&count($this->PageOptions>0)) {
			
			foreach ($this->PageOptions as $href=>$menu) {
				if ($type) {
					add_submenu_page( 'OptionsPage', $menu['name'], $menu['name'], 'manage_options', $href, array(&$this,'ThemeOptionsPage'));
				} else {
					echo "<li class='".((($_GET['page']==$href)||($_GET['page']=='OptionsPage'&&$href=='general'))?'active':'')."'>
					<img src='".get_template_directory_uri()."/inc/images/menu/".$href.".png' alt='".$menu['name']."' />".$menu['name']."</li>";
				}
			}
			remove_submenu_page( 'OptionsPage', 'OptionsPage' );
		}
	}
	
	function load_tabs_content($type=0) {
		
		if (is_array($this->PageOptions)&&count($this->PageOptions>0)) {
			foreach ($this->PageOptions as $href=>$x) {
				echo '<li id="'.$href.'" '.((($_GET['page']==$href)||($_GET['page']=='OptionsPage'&&$href=='general'))?" style='display:block' class='content-li active'":' class="content-li"').'><h2>'.$x['name'].'</h2><div class="adm-form">';
				if ($href!='activate') echo '<form id="form_'.$href.'" method="POST">';
				echo "<input type='hidden' name='option' value='".$href."' />";
				foreach ($x['content'] as $param) {
					$param['option']=$href;
					$this->show_input( $param );
				}
				if ($href!='activate') echo '</form>';
				echo '</div></li>';
			}
		}
	}
	
	function show_input($param){	
		global $SMTheme;
		switch ($param['type']) {
						case 'p':
							?>
							<div class='item' style='font-style:italic;'>
								<?php echo $param['value']?>
							</div>
							<?php
						break;
						case 'sidebars':
							?>
							<div class='item'>
								<p class='p_ttl'>
								<?php if (isset($param['hint'])&&$param['hint']!='') { ?>
								<span class='hint' alt='<?php echo $param['hint']?>'><img src='<?php echo get_template_directory_uri()?>/inc/images/hint.png' /></span>
								<?php } ?>
								<span class='span'><?php echo $param['ttl']?></span></p>
								<div class='sidebarselector'>
									<img src="<?php echo get_template_directory_uri()?>/inc/images/sidebar-no.png" alt="No Sidebars" title="No Sidebars" />
									<img src="<?php echo get_template_directory_uri()?>/inc/images/sidebar-r.png" alt="Right Sidebar" title="Right Sidebar" />
									<img src="<?php echo get_template_directory_uri()?>/inc/images/sidebar-l.png" alt="Left Sidebar" title="Left Sidebar" />
									<img src="<?php echo get_template_directory_uri()?>/inc/images/sidebar-lr.png" alt="Left and Right Sidebars" title="Left and Right Sidebars" />
									<img src="<?php echo get_template_directory_uri()?>/inc/images/sidebar-r2.png" alt="2 Right Sidebars" title="2 Right Sidebars" />
									<img src="<?php echo get_template_directory_uri()?>/inc/images/sidebar-l2.png" alt="2 Left Sidebars" title="2 Left Sidebars" />
									<select autocomplete='off' name='<?php echo $param['name']?>' class='tinput' id='list_<?php echo $param['name']?>'>
									<?php
										foreach ($param['params'] as $value=>$option) {
											?><option value='<?php echo $value?>'<?php echo ($param['value']==$value)?" selected='selected'":""?>><?php echo $option?></option><?php
										}
									?>
									</select>
									<script>
										jQuery('.sidebarselector img').eq(jQuery('.sidebarselector select option:selected').index()).addClass('active');
									</script>
								</div>
							</div>
							<?php
						break;
						case 'activator':
							?>
							<?php
								if ($handle=@fopen(TEMPLATEPATH."/license.txt", 'r')) {
									$txt=fread($handle, filesize(TEMPLATEPATH."/license.txt"));
									if ( preg_match('/Theme\sActivated:\s(.*)/', $txt, $matches) ) {
										?>
										<div class='item'>
											Theme was successfuly activated with key <?php echo $matches[1];?>
										</div>
										<?php
										break;
									}
								}
							?>
							<div class='item'>
								<?php
									$info=get_theme_data(TEMPLATEPATH.'/style.css');
									$themename=strtolower($info['Name']);
								?>
								<ul class='rightlinks'>
									<li><a href="http://smthemes.com/support">Forum</a></li>
									<li><a href="http://smthemes.com/buy/<?php echo $themename; ?>/">Buy Theme</a></li>
									<li><a href="http://smthemes.com/terms-of-services/">Licence</a></li>
									<li><a href="/wp-admin/admin.php?page=activate&restore_footer=1">Restore Footer</a></li>
								</ul>
								You can simply remove links from the footer after purchase and activate the theme.<br />
							</div>
								<div class='item activation-purchase'>
										<?php
											$data[]='domain='.$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_NAME'];
											$data[]='info='.$info['Name'];
											$data[]='theme='.get_template_directory_uri();
											$smt_hash=md5(rand(0,mktime()));
											update_option('smt_hash',$smt_hash);
											$data[]='smt_hash='.$smt_hash;
											$data='?'.implode('&', $data);
										?>
									<iframe src='http://smthemes.com/purchase-from-users-dashboard-vertical/<?php echo $data; ?>' width='100%' height='100px' scrolling='no'>
									</iframe>
									
								</div>
								<div class='item activation-activate'>
									<p class='p_ttl'>
									
									<span class='hint' alt='<?php echo $param['hint']?>'><img src='<?php echo get_template_directory_uri()?>/inc/images/hint.png' /></span>
									
									
									<span class='span'>Activate theme</span></p>
									
									
									<div id='activation-params' method='POST' action=''>
										<?php
											$data=array();
											$data['domain']=$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_NAME'];
											$data['info']=get_theme_data(TEMPLATEPATH.'/style.css');
											$data['info']=$data['info']['Name'];
											$data['theme']=get_template_directory_uri();
											$data['smt_hash']=$smt_hash;
											foreach ( $data as $key => $value ) {
												echo "<input type='hidden' name='".$key."' value='".$value."' />";
											}
										?>
										<input type='hidden' name='abs' value='<?php echo dirname(__FILE__); ?>' />
										<input class='tinput' id='act_key' type='text' name='act_key' value=''  style='float:left;width:80%;' />
									</div>
									<center><input type='button' class='activate' value='Activate'></center>
									
									<iframe height='500px' width='100%' src='' id='sActivator' onLoad='jQuery("#imgloader").hide();' style='margin-top:25px;'>
									</iframe>
								</div>
							<?php
						break;
						case 'updates':
							?>
							<div class='item'>
								<p class='p_ttl'>
								<?php if (isset($param['hint'])&&$param['hint']!='') { ?>
								<span class='hint' alt='<?php echo $param['hint']?>'><img src='<?php echo get_template_directory_uri()?>/inc/images/hint.png' /></span>
								<?php } ?>
								<span class='span'><?php echo $param['ttl']?></span></p>
								<div id="updatesfrm"></div>
							</div>
							<?php
						break;
						case 'text':
							?>
							<div class='item'>
								<p class='p_ttl'>
								<?php if (isset($param['hint'])&&$param['hint']!='') { ?>
								<span class='hint' alt='<?php echo $param['hint']?>'><img src='<?php echo get_template_directory_uri()?>/inc/images/hint.png' /></span>
								<?php } ?>
								<span class='span'><?php echo $param['ttl']?></span></p>
								<input autocomplete='off' class='tinput' type='text' name='<?php echo $param['name']?>' value="<?php echo htmlspecialchars($param['value']);?>" />
							</div>
							<?php
						break;
						case 'textarea':
							?>
							<div class='item'>
								<p class='p_ttl'>
								<?php if (isset($param['hint'])&&$param['hint']!='') { ?>
								<span class='hint' alt='<?php echo $param['hint']?>'><img src='<?php echo get_template_directory_uri()?>/inc/images/hint.png' /></span>
								<?php } ?>
								<span class='span'><?php echo $param['ttl']?></span></p>
								<textarea autocomplete='off' class='tinput' name='<?php echo $param['name']?>'><?php echo $param['value']?></textarea>
							</div>
							<?php
						break;
						case 'file':
							?>
							<div class='item'>
								<p class='p_ttl'>
								<?php if (isset($param['hint'])&&$param['hint']!='') { ?>
								<span class='hint' alt='<?php echo $param['hint']?>'><img src='<?php echo get_template_directory_uri()?>/inc/images/hint.png' /></span>
								<?php } ?>
								<span class='span'><?php echo $param['ttl']?></span></p>
								<img src='<?php echo $param['value']?>' alt='' id='img_<?php echo $param['name']?>' /><br />
								<input autocomplete='off' class='tinput finput' type='text' id="up_<?php echo $param['name']?>" name='<?php echo $param['name']?>' value='<?php echo $param['value']?>' />
								<span class="gc_imageupload button" id="upb_<?php echo $param['name']?>">Upload</span>
							</div>
							<?php
						break;
						case 'check':
							if (isset( $param['depend'] )) { 
								$plugins = implode(',', get_option('active_plugins'));
								if (!preg_match('/'.$param['depend'].'/', $plugins)) break;
							}
							?>
							<div class='item'>
								<p class='p_ttl'>
								<?php if (isset($param['hint'])&&$param['hint']!='') { ?>
								<span class='hint' alt='<?php echo $param['hint']?>'><img src='<?php echo get_template_directory_uri()?>/inc/images/hint.png' /></span>
								<?php } ?>
								<span class='span'><?php echo $param['ttl']?></span></p>
								<span class='tcheck'><input type='checkbox' name='<?php echo $param['name']?>' value='1' <?php echo ($param['value'])?"checked='checked'":""?> /></span>
							</div>
							<?php
						break;
						case 'select':
							?>
							<div class='item'>
								<p class='p_ttl'>
								<?php if (isset($param['hint'])&&$param['hint']!='') { ?>
								<span class='hint' alt='<?php echo $param['hint']?>'><img src='<?php echo get_template_directory_uri()?>/inc/images/hint.png' /></span>
								<?php } ?>
								<span class='span'><?php echo $param['ttl']?></span></p>
								<select autocomplete='off' name='<?php echo $param['name']?>' class='tinput' id='list_<?php echo $param['name']?>'>
									<?php
										foreach ($param['params'] as $value=>$option) {
											?><option value='<?php echo $value?>'<?php echo ($param['value']==$value)?" selected='selected'":""?>><?php echo $option?></option><?php
										}
									?>
								</select>
							</div>
							<?php
						break;
						case 'variants':
							?>
							<div class='item'>
								<ul id='depended_<?php echo $param['depend']?>' class='variants'>
									<?php
										foreach($param['variants'] as $value=>$func) {
											if (is_callable(array(get_class($this), $func))) {
?>
<li id='variant_<?php echo $value?>' class='variant'<?php echo (($value==$SMTheme->get($param['option'], $param['depend']))?" style='display:block'":"")?>>
<?php
												call_user_func(array( get_class($this), $func));
												echo "</li>";
											}
										}
									?>
								</ul>
								<script>
									jQuery(document).ready(function() {
										jQuery('#list_<?php echo $param['depend']?>').live('change', function() {
											jQuery('#depended_<?php echo $param['depend']?> li.variant').hide();
											jQuery('#depended_<?php echo $param['depend']?> #variant_'+jQuery(this).val()).show();
										});
									});
								</script>
							</div>
							<?php
						break;
						case 'group':
							?>
							<span class='group_ttl'><?php echo $param['ttl']?></span>
							<div class='group_box' alt='<?php echo $param['name']?>'>
								<?php
									foreach ($param['content'] as $key=>$value){
										$value['value']=$param['value'][$key];
										$value['name']=$param['name']."[".$value['name']."]";
										$this->show_input($value);
									}
								?>
							</div>
							<?php
						break;
						case 'details':
							?>
							<p class='p_ttl'>
								<?php if (isset($param['hint'])&&$param['hint']!='') { ?>
								<span class='hint' alt='<?php echo $param['hint']?>'><img src='<?php echo get_template_directory_uri()?>/inc/images/hint.png' /></span>
								<?php } ?>
								<span class='span'><?php echo $param['ttl']?></span></p>
							<div class='detailsbox' alt='<?php echo $param['name']?>'>
									<input type='hidden' name='details' value='' />
									<ul class='contact-details'>
									<?php
										foreach ($param['value'] as $key=>$detail) {
										?>
											<li style='display:block;background:url(<?php echo $detail['img']?>) left top no-repeat;' alt='<?php echo $key?>'><span><?php echo $detail['content']?></span>
											<input type='hidden' name='details[<?php echo $key?>][img]' value='<?php echo $detail['img']?>' />
											<input type='hidden' name='details[<?php echo $key?>][content]' value='<?php echo $detail['content']?>' />
											<span class="itemdelete" title="Delete"></span>
											<span class="itemedit" title="Edit"></span>
											</li>
											
										<?php
										}
									?>
									</ul>
									<div class='newdetail'>
									<p>Image URL (32x32 px)<span class="selectimg button" style='float:right;margin-left:5px;margin-bottom:10px;'>Presets</span><span class="gc_imageupload button" id="upb_new_detail_img" style='float:right'>Upload</span>
									<div class='input'><div id='detailspreset'><table><tr>
										<td><img src='<?php echo get_template_directory_uri()?>/images/feedback/mail.png' /></td>
										<td><img src='<?php echo get_template_directory_uri()?>/images/feedback/geo.png' /></td>
										<td><img src='<?php echo get_template_directory_uri()?>/images/feedback/phone.png' /></td>
										<td><img src='<?php echo get_template_directory_uri()?>/images/feedback/icq.png' /></td>
										<td><img src='<?php echo get_template_directory_uri()?>/images/feedback/skype.png' /></td>
									</tr></table></div><input class='tinput' type='text' id="up_new_detail_img" value='' /></div>
									</p>
									<p>Value</p>
									<div class='input'><input class='tinput' type='text' id='new_detail_value' value='' /></div>
									</p>
									<span class="button save_detail_btn" alt="" style='float:right'>Save detail</span>
									<span class="button add_detail_btn" style='float:right'>Add detail</span>
									</div>
									<div style='clear:both;margin-bottom:20px;'></div>
							</div>
							<?php
						break;
						case 'contactform':
							?>
							<p class='p_ttl'>
								<?php if (isset($param['hint'])&&$param['hint']!='') { ?>
								<span class='hint' alt='<?php echo $param['hint']?>'><img src='<?php echo get_template_directory_uri()?>/inc/images/hint.png' /></span>
								<?php } ?>
								<span class='span'><?php echo $param['ttl']?></span></p>
							<div class='detailsbox' alt='<?php echo $param['name']?>'>
								<table>
									<tr class='th'>
										<th style='width:24px'></th>
										<th style='width:40%'>Caption</th>
										<th class='advanced' style='width:30%'>Regex for check</th>
										<th>Type</th>
										<th>Required</th>
										<th></th>
									</tr>
									<?php
										foreach ($param['value'] as $key=>$detail) {
										?>
											<tr alt='<?php echo $key?>'>
											<td class='trdrag'></td>
											<td style='width:50%'>
												<input type='text' class='tinput' name='contactform[<?php echo $key?>][ttl]' value='<?php echo $detail['ttl']?>' />
											</td>
											<td class='advanced' style='width:30%'>
												<input type='text' class='tinput' name='contactform[<?php echo $key?>][regex]' value='<?php echo stripslashes($detail['regex'])?>' />
											</td>
											<td>
												<select name='contactform[<?php echo $key?>][type]' class='tselect'>
													<option value='text'<?php echo ($detail['type']=='text')?' selected="selected"':""?>>Text field</option>
													<option value='textarea'<?php echo ($detail['type']=='textarea')?' selected="selected"':""?>>Text area</option>
												</select>
											</td>
											<td>
												<input type='checkbox' name='contactform[<?php echo $key?>][req]' value='required' <?php echo ($detail['req'])?' checked="checked"':'';?> />
											</td>
											<td>
												<span class='tableitemdelete' title='Delete'></span>
											</td>
											</tr>
											
										<?php
										}
									?>
								</table>
								<span class="button add_form_btn" style='float:right'>Add input</span><span class="button advanced_settings" style='float:right;margin-right:5px;'>Advanced Settings</span>
							</div>
							<?php
						break;
						case 'socials':
							?>
							<p class='p_ttl'>
								<?php if (isset($param['hint'])&&$param['hint']!='') { ?>
								<span class='hint' alt='<?php echo $param['hint']?>'><img src='<?php echo get_template_directory_uri()?>/inc/images/hint.png' /></span>
								<?php } ?>
								<span class='span'><?php echo $param['ttl']?></span></p>
								
							<div class='socialbox' alt='<?php if (isset($param['name'])) echo $param['name']; ?>'>
								<table>
									<tr class='th'>
										<th style='width:24px'></th>
										<th style='width:40%'>Service</th>
										<th>Display</th>
										<th></th>
									</tr>
									<?php
										foreach ($param['value'] as $key=>$detail) {
										?>
											<tr alt='<?php echo $key?>'>
											<td class='trdrag'>
												<input type='hidden' class='param-ttl' name='socials[<?php echo $key?>][ttl]' value='<?php echo $detail['ttl']?>' />
												<input type='hidden' class='param-code' name='socials[<?php echo $key?>][code]' value='<?php echo $detail['code']?>' />
											</td>
											<td style='width:50%' class='displ-ttl'>
												<?php echo $detail['ttl']?>
											</td>
											<td>
												<input type='checkbox' name='socials[<?php echo $key?>][show]' value='1' <?php echo ($detail['show'])?' checked="checked"':'';?> />
											</td>
											<td><span class="button edit_social_btn">Edit</span></td>
											</tr>
											
										<?php
										}
									?>
								</table>
								<span class="button add_social_btn" style='float:right' alt='<?php echo $key+1;?>'>Add Button</span>
							</div>
							<div class="window" id="new_social" alt=''>
									<div class='transparent'></div><div class='inner'><div class='inner2'><table>
									<tr><td>Title:</td><td><input class='tinput' type='text' value='' /></td></tr>
									<tr><td>Code:</td><td><textarea class='tinput' rows='10'></textarea></td></tr>
									<tr><td></td></tr>
									<tr><td></td><td><span class='button cancel_btn' style='float:right'>Cancel</span><span class='button save_social_btn' style='float:right'>Save</span></td></tr>
									</table></div></div>
								</div>
							<?php
						break;
					}
	}
	
	function logoimage() {
		$param=$this->PageOptions['general']['content']['logoimage'];
		?>
			<div class='item'>
								<p class='p_ttl'>
								<?php if (isset($param['hint'])&&$param['hint']!='') { ?>
								<span class='hint' alt='<?php echo $param['hint']?>'><img src='<?php echo get_template_directory_uri()?>/inc/images/hint.png' /></span>
								<?php } ?>
								<span class='span'><?php echo $param['ttl']?></span></p>
								<img src='<?php echo $param['value']?>' alt='' id='img_<?php echo $param['name']?>' /><br />
								<input class='tinput finput' type='text' id="up_<?php echo $param['name']?>" name='<?php echo $param['name']?>' value='<?php echo $param['value']?>' />
								<span class="gc_imageupload button" id="upb_<?php echo $param['name']?>">Upload</span>
							</div>
		<?php
	}
	
	function customtext() {
		$param=$this->PageOptions['general']['content']['customtext'];
		?>
			<div class='item'>
								<p class='p_ttl'>
								<?php if (isset($param['hint'])&&$param['hint']!='') { ?>
								<span class='hint' alt='<?php echo $param['hint']?>'><img src='<?php echo get_template_directory_uri()?>/inc/images/hint.png' /></span>
								<?php } ?>
								<span class='span'><?php echo $param['ttl']?></span></p>
								<input autocomplete='off' class='tinput' type='text' name='<?php echo $param['name']?>' value="<?php echo htmlspecialchars($param['value']);?>" />
							</div>
		<?php
	}
	
	function category() {
		
		if ( $this->PageOptions['slider']['content']['category']['value'] =='' ) $this->PageOptions['slider']['content']['category']['value'] = array();
		$params = $this->PageOptions['slider']['content']['category']['value'];
		
		$params = array_merge ( array( 
			'orderby' => 'date',
			'numberposts' => 5,
			'category' => 0
		), $params );
		?>
			<div class='item'>
				<p class='p_ttl'><span class='span'>Number of slides:</span></p>
				<input class='tinput' type='text' name='category[numberposts]' value='<?php echo $params['numberposts']?>' />
			</div>
			<div class='item'>
				<p class='p_ttl'><span class='span'>Category:</span></p>
				<?php
					$categories=get_categories();
				?>
				<select name='category[category]' class='tinput'>
					<option value='0'>All categories</option>
					<?php
						foreach ($categories as $cat) {
							?><option value='<?php echo $cat->cat_ID?>'<?php echo ($cat->cat_ID==$params['category'])?" selected='selected'":""?>><?php echo $cat->name?> (<?php echo $cat->count?>)</option><?php
						}
					?>
				</select>
			</div>
			<div class='item'>
				<p class='p_ttl'><span class='span'>Order by:</span></p>
				<?php
					$categories=get_categories();
				?>
				<select name='category[orderby]' class='tinput'>
					<option value='date'<?php echo ($params['orderby']=='date')?" selected='selected'":""?>>Created</option>
					<option value='modified'<?php echo ($params['orderby']=='modified')?" selected='selected'":""?>>Modified</option>
					<option value='title'<?php echo ($params['orderby']=='title')?" selected='selected'":""?>>Title</option>
				</select>
			</div>
		<?php
	}
	
	function posts() {
		
		$params=$this->PageOptions['slider']['content']['posts']['value'];
		?>
			<div class='item' alt='posts[]'>
				<p class='p_ttl'><span class='span'>Posts:</span></p>
				<?php
					$posts=get_posts('orderby=title&numberposts=0');
					if (is_array($params))foreach ($params as $post_id) {
						$cpost=get_post( $post_id );
						?>
					<select name='posts[]' class='tinput changeselect' alt="<option value='<?php echo $cpost->ID?>'><?php echo $cpost->post_title?></option>">
						<option value='0'>Delete</option>
						<?php
							foreach ($posts as $post) {
								if (!in_array($post->ID,$params)||$post->ID==$post_id) {
								?><option value='<?php echo $post->ID?>'<?php echo (($post->ID==$post_id)?" selected=\"selected\"":"")?>><?php echo $post->post_title?></option><?php
								}
							}
						?>
					</select>
						<?php
					}
					
					if (count($posts)!=count($params)) {
				?>
				
					<select name='' class='tinput addselect'>
						<option value='0'>Select post</option>
						<?php
							foreach ($posts as $post) {
								if (!in_array($post->ID,$params)) {
									?><option value='<?php echo $post->ID?>'><?php echo $post->post_title?></option><?php
								}
							}
						?>
					</select>
				<?php } ?>
			</div>
		<?php
	}
	
	function pages() {
		
		$params=$this->PageOptions['slider']['content']['pages']['value'];
		?>
			<div class='item' alt='pages[]'>
				<p class='p_ttl'><span class='span'>Pages:</span></p>
				<?php
					$pages=get_pages('orderby=title');
					if (is_array($params))foreach ($params as $page_id) {
						$cpage=get_page($page_id);
						?>
					<select name='pages[]' class='tinput changeselect' alt="<option value='<?php echo $cpage->ID?>'><?php echo $cpage->post_title?></option>">
						<option value='0'>Delete</option>
						<?php
							foreach ($pages as $page) {
								if (!in_array($page->ID,$params)||$page->ID==$page_id) {
								?><option value='<?php echo $page->ID?>'<?php echo (($page->ID==$page_id)?" selected=\"selected\"":"")?>><?php echo $page->post_title?></option><?php
								}
							}
						?>
					</select>
						<?php
					}
					
					if (count($pages)!=count($params)||(!is_array($params))) {
				?>
				
					<select name='' class='tinput addselect'>
						<option value='0'>Select page</option>
						<?php
							foreach ($pages as $page) {
								if (!in_array($page->ID,$params)) {
									?><option value='<?php echo $page->ID?>'><?php echo $page->post_title?></option><?php
								}
							}
						?>
					</select>
				<?php } ?>
			</div>
		<?php
	}
	
	function custom_slides() {
		$slides = $this->PageOptions['slider']['content']['custom_slides']['value'];
		?>
		<input type='hidden' name='custom_slides' value='0' />
		<div class='custom_slides'>
			<div class='slides_list'>
			<?php if ( count( $slides ) && is_array( $slides ) ) foreach($slides as $num=>$slide) { ?>
			
				<div class="slide_item">
					<img src="<?php echo preg_replace('/(.*)\.(.*)/', '$1-prev.$2', $slide['img'])?>" width="56" height="56" alt="<?php echo $slide['ttl']?>" title="<?php echo $slide['ttl']?>" />
					<div class="slide_settings">
						<div class='transparent'></div><div class='inner'><table>
						<tr><td>Image URL:</td><td><input class='tinput finput' type='text' id='up_new_slide_img_<?php echo $num?>' name='custom_slides[<?php echo $num?>][img]' value='<?php echo $slide['img']?>' /><span class='gc_imageupload button' id='upb_new_slide_img_<?php echo $num?>'>Upload</span></td></tr>
						<tr><td>Link URL:</td><td><input class='tinput' type='text' name='custom_slides[<?php echo $num?>][link]' id='new_slide_link_<?php echo $num?>' value='<?php echo $slide['link']?>' /></td></tr>
						<tr><td>Title:</td><td><input class='tinput' type='text' name='custom_slides[<?php echo $num?>][ttl]' id='new_slide_ttl_<?php echo $num?>' value='<?php echo $slide['ttl']?>' /></td></tr>
						<tr><td>Content:</td><td><textarea class='tinput' id='new_slide_content_<?php echo $num?>' name='custom_slides[<?php echo $num?>][content]'><?php echo $slide['content']?></textarea></td></tr>
						<tr><td></td><td><span class='button delete_slide_btn' style='float:right' alt="<?php echo $num?>">Delete</span><span class='button save_slide_btn' style='float:right'>Save</span></td></tr>
						</table></div>
					</div>
				</div>
			<?php } ?>
			</div>
			<script>
					jQuery( function() {
						jQuery( ".slides_list" ).sortable({
						  placeholder: "slide_item_highlight"
						});
					});
			</script>
			<dt class='add_dt'><span>Add slide</span></dt>
			<dd class='add_dd'>
				<table>
					<tr><td>Image URL:</td><td><input class='tinput finput' type='text' id="up_new_slide_img" value='' /><span class="gc_imageupload button" id="upb_new_slide_img">Upload</span></td></tr>
					<tr><td>Link URL:</td><td><input class='tinput' type='text' id='new_slide_link' value='' /></td></tr>
					<tr><td>Title:</td><td><input class='tinput' type='text' id='new_slide_ttl' value='' /></td></tr>
					<tr><td>Content:</td><td><textarea class='tinput' id='new_slide_content' ></textarea></td></tr>
					<tr><td></td><td><span class="button add_slide_btn" style='float:right'>Add slide</span></td></tr>
				</table>
			</dd>
		</div>

		<?php
	}
	
	function ajax_callback() {
		if ((in_array($_POST['task'],$this->tasks))&&is_callable(array(get_class($this), $this->tasks[0]))) {
            call_user_func(array( get_class($this), $_POST['task']));
        }
		
		die();
	}
	
	function imageupload() {
		
		$exts = array('jpg','png','gif','jpeg','ico');
		$file=$_FILES[$_POST['img']];
		$ext=explode('.',$file['name']);
		$ext=$ext[count($ext)-1];
		if (in_array($ext, $exts)) {
			$override['test_form']=false;
			$file=wp_handle_upload($file,$override);
			
			if (preg_match('/upb_new_slide_img/', $_POST['sender'])) {
				image_resize($file['file'], 56, 56, true, 'prev');
			}
			echo $file['url'];
		} else echo 'Unallowed file extention';
	}
	
	function formsave() {
	
		$option=$_POST['option'];
		if (isset($this->PageOptions[$option])) {
			$options=$_POST;
			unset($options['option']);
			unset($options['task']);
			$options=removeslashes($options);
			update_option($option,$options);
		}
		echo 'New configuration saved';
		
	}
	
	function activate() {
		$data['domain']=$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_NAME'];
		$data['info']=get_theme_data(TEMPLATEPATH.'/style.css');
		$data['info']=$data['info']['Name'];
		$data['theme']=get_template_directory_uri();
		$data['act_key']=(string)$_POST['act_key'];
		$name = $info['Name']?$info['Name']:'SMT Options';
		$url="http://smthemes.com/index.php?activation=4";
		error_reporting(15);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, "Accept: application/xml");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
		$response = curl_exec($ch); 
		curl_close($ch);
		print_r($response);
		if (preg_match('/okbox/', $response)) {
			$save=array('activator'=>'Your theme was successful activated at '.date('Y.m.d').' with activation key '.$data['act_key']);
			update_option('activate',$save); 
		}
	}

}

function removeslashes($var) {
	if (is_array($var)) foreach ($var as $key=>$value) {
		$var[$key]=removeslashes($value);
	} else {
		return stripslashes($var);
	}
	return $var;
}
?>