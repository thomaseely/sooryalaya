<?php
/**
 * The footer template
 *
 * @package WPlook
 * @subpackage Morning Time Lite
 * @since Morning Time Lite 1.0
 */
?>

<footer class="footer">
		<div class="footer-body">
			<div class="row">
				<div class="columns large-4">
					<?php if ( is_active_sidebar( 'f1-widgets' ) ) : ?>
						<?php dynamic_sidebar( 'f1-widgets' ); ?>
					<?php endif; ?>
				</div><!-- /.columns large-4 -->

				<div class="columns large-4">
					<!-- Second Widget area -->
					<?php if ( is_active_sidebar( 'f2-widgets' ) ) : ?>
						<?php dynamic_sidebar( 'f2-widgets' ); ?>
					<?php endif; ?>
				</div><!-- /.columns large-4 -->

				<div class="columns large-4">
					<!-- Third Widget area -->
					<?php if ( is_active_sidebar( 'f3-widgets' ) ) : ?>
						<?php dynamic_sidebar( 'f3-widgets' ); ?>
					<?php endif; ?>
				</div><!-- /.columns large-4 -->
			</div><!-- /.row -->
		</div><!-- /.footer-body -->

		<div class="footer-bar">
			<div class="row">
				<div class="columns large-12">
					<div class="enquiry">
					<ul>
					<li class="border-rght"><h4>Booking</h4><h5><a href="mailto:booking@sooryalaya.com?subject=Booking Sooryalaya">booking@sooryalaya.com</a></h5></li>
					<li><h4>Enquiries</h4><h5><a href="mailto:hello@sooryalaya.com?subject=Enquiry to Sooryalaya">hello@sooryalaya.com</a></h5></li>
					
					</ul>
					
					<div class="social">
					<a class="" href="#"><i class="fa fa-facebook"></i></a>
					<a class="" href="#"><i class="fa fa-twitter"></i></a>
					<a class="" href="#"><i class="fa fa-google-plus"></i></a>
					</div>
					
					</div>
				
					<?php
						if ( has_nav_menu( 'footernav' ) ) { ?>
							<nav class="footer-nav ">
								<?php wp_nav_menu( array('depth' => '3', 'theme_location' => 'footernav', 'container'	 => '','depth' => -1, )); ?>
							</nav>
					<?php } ?>
				</div><!-- /.columns large-6 -->
			</div><!-- /.row -->
		</div><!-- /.footer-bar -->
	</footer><!-- /.footer -->
</div><!-- /.wrapper -->
<?php wp_footer(); ?>
</body>
</html>