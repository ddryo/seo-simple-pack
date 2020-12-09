<div id="ssp_wrap" class="wrapp">
	<h1 id="ssp_title"><?=__( 'Help page', 'loos-ssp' )?></h1>

	<div id="poststuff">
		<div class="ssp_help_page">
			<?=__( 'About available "snippet tags"', 'loos-ssp' )?>
			<br> 
			<?php
				$tags = [
					'site_title'       => __( 'Site title', 'loos-ssp' ),
					'phrase'           => __( 'Site catchphrase', 'loos-ssp' ),
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
			<table class="ssp_help_table">
				<thead>
					<tr>
						<th>
							<?=__( 'Snippet tag', 'loos-ssp' )?>
						</th>
						<th>
							<?=__( 'Contents to be expanded', 'loos-ssp' )?>
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

			<p>
				<?php
					echo sprintf(
						__( 'See %s for more information about "SEO SIMPLE PACK".', 'loos-ssp' ),
						'<a href="https://wemo.tech/1670" target="_blank">' . __( '"How to use the plugin"', 'loos-ssp' ) . '</a>'
					);
				?>
			</p>
		</div>
	</div>
</div>
