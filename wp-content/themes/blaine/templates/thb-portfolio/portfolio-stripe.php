<?php thb_portfolio_query(); ?>

<?php if( have_posts() ) : ?>
	
	<ul id="thb-stripe-portfolio">
		<?php while( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php thb_portfolio_item( array(
				'portfolio_item_template' => $portfolio_item_template
			) ); ?>
		<?php endwhile; ?>
	</ul>

<?php endif; ?>