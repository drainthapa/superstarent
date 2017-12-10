		</div>
		        <!-- wrapper -->
		        
		    </div>
		    <!-- main-content -->

		    <?php get_template_part('modules/socials', 'bottom'); ?>
		    <!-- footer-social-box -->

		    <div id="kopa-page-footer">

		    	<div class="mask"></div>
		    	<?php if(is_active_sidebar('footer-1-sidebar') || is_active_sidebar('footer-2-sidebar') || is_active_sidebar('footer-3-sidebar')): ?>
			    	<div id="bottom-sidebar">

			    		<div class="wrapper">

			    			<div class="row">
			    				
			    				<?php
									if(is_active_sidebar('footer-1-sidebar')){
								    echo '<div class="col-md-4 col-sm-4">';
								    dynamic_sidebar('footer-1-sidebar');             
								    echo '</div>';
									}

									if(is_active_sidebar('footer-2-sidebar')){
								    echo '<div class="col-md-4 col-sm-4">';
								    dynamic_sidebar('footer-2-sidebar');             
								    echo '</div>';
									}

									if(is_active_sidebar('footer-3-sidebar')){
								    echo '<div class="col-md-4 col-sm-4">';
								    dynamic_sidebar('footer-3-sidebar');             
								    echo '</div>';
									}
			    				?>
			    				
			    				
			    			</div>
			    			<!-- row -->
			    			
			    		</div>
			    		<!-- wrapper -->		    	
				    </div>
			  	<?php endif;?>
			    <!-- bottom-sidebar -->

			    <footer id="kopa-footer">

			    	<div class="wrapper clearfix">

			    	<?php get_template_part('modules/copyright'); ?>

						<?php get_template_part('modules/menu', 'footer'); ?>

						<?php get_template_part('modules/back-to-top'); ?>
			    		
			    	</div>
			    	<!-- wrapper -->
			    	
			    </footer>
			    <!-- kopa-footer -->
		    	
		    </div>
		    <!-- kopa-page-footer -->
		    
        <?php wp_footer(); ?>
    </body>
</html>
