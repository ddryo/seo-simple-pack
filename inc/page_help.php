<?php
/**
 * Help page
 */
$SNIPPET_TAGS = [
	'site_title'        => [
		'label' => __( 'Site title', 'seo-simple-pack' ),
		'for'   => __( 'All pages', 'seo-simple-pack' ),
	],
	'tagline'           => [
		'label' => __( 'Site catchphrase', 'seo-simple-pack' ),
		'for'   => __( 'All pages', 'seo-simple-pack' ),
	],
	'front_description' => [
		'label' => __( 'Front description', 'seo-simple-pack' ),
		'for'   => __( 'All pages', 'seo-simple-pack' ),
	],
	'sep'               => [
		'label' => __( 'Delimiter', 'seo-simple-pack' ),
		'for'   => __( 'All pages', 'seo-simple-pack' ),
	],
	'page_title'        => [
		'label' => __( 'Post title', 'seo-simple-pack' ),
		'for'   => __( 'Posts and Pages', 'seo-simple-pack' ),
	],
	'page_contents'     => [
		'label' => __( 'Page content', 'seo-simple-pack' ),
		'for'   => __( 'Posts and Pages', 'seo-simple-pack' ),
	],
	'term_name'         => [
		'label' => __( 'Term name', 'seo-simple-pack' ),
		'for'   => __( 'Term archives', 'seo-simple-pack' ),
	],
	'term_description'  => [
		'label' => __( 'Term description', 'seo-simple-pack' ),
		'for'   => __( 'Term archives', 'seo-simple-pack' ),
	],
	'tax_name'          => [
		'label' => __( 'Taxonomy name', 'seo-simple-pack' ),
		'for'   => __( 'Taxonomy archives', 'seo-simple-pack' ),
	],
	'post_type'         => [
		'label' => __( 'Post type name', 'seo-simple-pack' ),
		'for'   => __( 'Post Type archives', 'seo-simple-pack' ),
	],
	'date'              => [
		'label' => __( 'The date that is searching in the date archive', 'seo-simple-pack' ),
		'for'   => __( 'Date archives', 'seo-simple-pack' ),
	],
	'author_name'       => [
		'label' => __( 'Author name', 'seo-simple-pack' ),
		'for'   => __( 'Author archives', 'seo-simple-pack' ),
	],
	'search_phrase'     => [
		'label' => __( 'Search word', 'seo-simple-pack' ),
		'for'   => __( 'Search results', 'seo-simple-pack' ),
	],
	'page'              => [
		'label' => __( 'Number of pages', 'seo-simple-pack' ),
		'for'   => __( 'All pages', 'seo-simple-pack' ),
	],
];

?>
<div class="ssp-page wrap">
	<h1 class="ssp-page__title">
		<?=esc_html__( 'Help page', 'seo-simple-pack' )?>
	</h1>
	<hr class="wp-header-end">
	<div class="ssp-page__body">
		<div class="ssp-page__section">
			<h2 class="ssp-page__section__title">
				<?=esc_html__( 'About available "snippet tags"', 'seo-simple-pack' )?>
			</h2>
			<div class="ssp-page__section__body">
				<table class="ssp-helpTable">
					<thead>
						<tr>
							<th>
								<?=esc_html__( 'Snippet tag', 'seo-simple-pack' )?>
							</th>
							<th>
								<?=esc_html__( 'Contents to be expanded', 'seo-simple-pack' )?>
							</th>
							<th>
								<?=esc_html__( 'Available page', 'seo-simple-pack' )?>
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
						printf(
							esc_html__( 'See %s for more information about "SEO SIMPLE PACK".', 'seo-simple-pack' ),
							'<a href="https://wemo.tech/1670" target="_blank">' . esc_html__( '"How to use the plugin"', 'seo-simple-pack' ) . '</a>'
						);
					?>
				</p>
			</div>
		</div>
	</div>
</div>
