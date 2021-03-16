<?php
/**
 * Help page
 */
$tags = [
	'site_title'       => __( 'Site title', 'loos-ssp' ),
	'tagline'          => __( 'Site catchphrase', 'loos-ssp' ),
	'phrase'           => __( 'Site catchphrase', 'loos-ssp' ) . ' ( ' . __( 'For backward compatibility', 'loos-ssp' ) . ' )',
	'description'      => __( 'Home description', 'loos-ssp' ),
	'page_title'       => __( 'Post title', 'loos-ssp' ),
	'cat_name'         => __( 'Category name', 'loos-ssp' ),
	'tag_name'         => __( 'Tag name', 'loos-ssp' ),
	'term_name'        => __( 'Term name', 'loos-ssp' ),
	'term_description' => __( 'Term description', 'loos-ssp' ),
	'tax_name'         => __( 'Taxonomy name', 'loos-ssp' ),
	'post_type'        => __( 'Post type name', 'loos-ssp' ),
	'page_contents'    => __( 'Page content', 'loos-ssp' ),
	'date'             => __( 'The date that is searching in the date archive', 'loos-ssp' ),
	'author_name'      => __( 'Author name', 'loos-ssp' ),
	'search_phrase'    => __( 'Search word', 'loos-ssp' ),
	'format_name'      => __( 'Post format name', 'loos-ssp' ),
	'sep'              => __( 'Delimiter', 'loos-ssp' ),
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
						</tr>
					</thead>
					<tbody>
						<?php
							foreach ( $tags as $key => $val ) {
							echo '<tr><th>%_' . $key . '_%</th><td>' . $val . '</td></tr>';
							}
						?>
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
