<?php 
$thb_socials = thb_get_social_networks();
$thb_get_copyright = thb_get_copyright();
?>

<?php if ( !empty($thb_socials) || !empty($thb_get_copyright) ) : ?>

	<footer id="footer">
		<div class="thb-section-container">
			
			<?php if ( thb_get_copyright() != '' ) : ?>
				<div id="copyright">
					<?php thb_copyright(); ?>
				</div>
			<?php endif; ?>

			<?php if ( count( $thb_socials ) > 0 ) : ?>
				<div id="social-icons">
					<?php foreach ( $thb_socials as $social ) : ?>
						<a target="_blank" href="<?php echo thb_get_social_network_url( $social ); ?>" class="thb-social-icon thb-<?php echo str_replace('social_', '', $social); ?>">
							<?php echo $social; ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		
		</div>
	</footer>

<?php endif; ?>