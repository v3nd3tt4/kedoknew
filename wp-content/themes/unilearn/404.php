<?php
	get_header();
	$home_url = get_site_url();
	?>
	<div id='page'>
		<div class='unilearn_layout_container'>
			<main id='page_content'>
				<section id='banner_404_section'>
					<div class='unilearn_layout_container'>
						<div id='banner_404'>
							<div id='banner_404_number'>
								4<mark>0</mark>4
							</div>
							<div id='banner_404_content'>
								<div id='banner_404_title'>
									<?php echo esc_html__( 'Sorry:&#40;', 'unilearn' ); ?>
								</div>
								<div id='banner_404_desc'>
									<?php echo esc_html__( 'This page doesn\'t exist.', 'unilearn' ); ?>
								</div>
							</div>
							<div id='banner_404_away'>
								<?php echo "<a href='$home_url' class='unilearn_button'>Proceed to our Home page</a>"; ?>
							</div>
						</div>
					</div>
				</section>
			</main>
		</div>
	</div>
	<?php
	get_footer();
?>