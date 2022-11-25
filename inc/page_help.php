<?php
/**
 * Help page
 */
$SNIPPET_TAGS = [
	'site_title' => [
		'label' => __( 'Site title', 'loos-ssp' ),
		'for'   => __( 'All pages', 'loos-ssp' ),
	],
	'tagline' => [
		'label' => __( 'Site catchphrase', 'loos-ssp' ),
		'for'   => __( 'All pages', 'loos-ssp' ),
	],
	'front_description' => [
		'label' => __( 'Front description', 'loos-ssp' ),
		'for'   => __( 'All pages', 'loos-ssp' ),
	],
	'sep' => [
		'label' => __( 'Delimiter', 'loos-ssp' ),
		'for'   => __( 'All pages', 'loos-ssp' ),
	],
	'page_title' => [
		'label' => __( 'Post title', 'loos-ssp' ),
		'for'   => __( 'Posts and Pages', 'loos-ssp' ),
	],
	'page_contents' => [
		'label' => __( 'Page content', 'loos-ssp' ),
		'for'   => __( 'Posts and Pages', 'loos-ssp' ),
	],
	'term_name' => [
		'label' => __( 'Term name', 'loos-ssp' ),
		'for'   => __( 'Term archives', 'loos-ssp' ),
	],
	'term_description' => [
		'label' => __( 'Term description', 'loos-ssp' ),
		'for'   => __( 'Term archives', 'loos-ssp' ),
	],
	'tax_name' => [
		'label' => __( 'Taxonomy name', 'loos-ssp' ),
		'for'   => __( 'Taxonomy archives', 'loos-ssp' ),
	],
	'post_type' => [
		'label' => __( 'Post type name', 'loos-ssp' ),
		'for'   => __( 'Post Type archives', 'loos-ssp' ),
	],
	'date' => [
		'label' => __( 'The date that is searching in the date archive', 'loos-ssp' ),
		'for'   => __( 'Date archives', 'loos-ssp' ),
	],
	'author_name' => [
		'label' => __( 'Author name', 'loos-ssp' ),
		'for'   => __( 'Author archives', 'loos-ssp' ),
	],
	'search_phrase' => [
		'label' => __( 'Search word', 'loos-ssp' ),
		'for'   => __( 'Search results', 'loos-ssp' ),
	],
	'page' => [
		'label' => __( 'Number of pages', 'loos-ssp' ),
		'for'   => __( 'All pages', 'loos-ssp' ),
	],
];

?>
<div class="ssp-page wrap">
	<h1 class="ssp-page__title">
		<?=esc_html__( 'Help page', 'loos-ssp' )?>
	</h1>
	<hr class="wp-header-end">
	<div class="ssp-page__body">
		<div class="ssp-page__section">
			<h2 class="ssp-page__section__title">
				<?=esc_html__( 'About available "snippet tags"', 'loos-ssp' )?>
			</h2>
			<div class="ssp-page__section__body">
				<table class="ssp-helpTable">
					<thead>
						<tr>
							<th>
								<?=esc_html__( 'Snippet tag', 'loos-ssp' )?>
							</th>
							<th>
								<?=esc_html__( 'Contents to be expanded', 'loos-ssp' )?>
							</th>
							<th>
								<?=esc_html__( 'Available page', 'loos-ssp' )?>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $SNIPPET_TAGS as $name => $data ) : ?>
							<tr>
								<td>
									<code>%_<?=esc_html( $name )?>_%</code>
								</td>
								<td>
									<?=esc_html( $data['label'] )?>
								</td>
								<td>
									<?=esc_html( $data['for'] )?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<p class="ssp-page__note">
					<?php
						echo sprintf(
							esc_html__( 'See %s for more information about "SEO SIMPLE PACK".', 'loos-ssp' ),
							'<a href="https://wemo.tech/1670" target="_blank">' . esc_html__( '"How to use the plugin"', 'loos-ssp' ) . '</a>'
						);
					?>
				</p>
			</div>
		</div>
	</div>
</div>
