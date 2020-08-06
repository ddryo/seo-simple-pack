<div id="ssp_wrap" class="wrapp">
    <h1 id="ssp_title"><?=__('Help page', LOOS_SSP_DOMAIN )?></h1>

    <div id="poststuff">
        <div class="ssp_help_page">
            <?=__('About available "snippet tags"', LOOS_SSP_DOMAIN )?>
            <br> 
            <?php 
                $tags = [
                    'site_title' => __( 'Site title', LOOS_SSP_DOMAIN ), 
                    'phrase' => __( 'Site catchphrase', LOOS_SSP_DOMAIN ), 
                    'description' => __( 'Home description', LOOS_SSP_DOMAIN ), 
                    'page_title' => __( 'Post title', LOOS_SSP_DOMAIN ), 
                    'cat_name' => __( 'Category name', LOOS_SSP_DOMAIN ), 
                    'tag_name' => __( 'Tag name', LOOS_SSP_DOMAIN ), 
                    'term_name' => __( 'Term name', LOOS_SSP_DOMAIN ), 
                    'term_description' => __( 'Term description', LOOS_SSP_DOMAIN ), 
                    'tax_name' => __( 'Taxonomy name', LOOS_SSP_DOMAIN ), 
                    'post_type' => __( 'Post type name', LOOS_SSP_DOMAIN ), 
                    'page_contents' => __( 'Page content', LOOS_SSP_DOMAIN ), 
                    'date' => __( 'The date that is searching in the date archive', LOOS_SSP_DOMAIN ), 
                    'author_name' => __( 'Author name', LOOS_SSP_DOMAIN ), 
                    'search_phrase' => __( 'Search word', LOOS_SSP_DOMAIN ), 
                    'format_name' => __( 'Post format name', LOOS_SSP_DOMAIN ), 
                    'sep' => __( 'Delimiter', LOOS_SSP_DOMAIN ), 
                ];
            ?>
            <table class="ssp_help_table">
                <thead>
                    <tr>
                        <th>
                            <?=__('Snippet tag', LOOS_SSP_DOMAIN )?>
                        </th>
                        <th>
                            <?=__('Contents to be expanded', LOOS_SSP_DOMAIN )?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach ($tags as $key => $val) {
                            echo '<tr><th>%_' . $key . '_%</th><td>' . $val . '</td></tr>';
                        }
                    ?>
                </tbody>
            </table>

            <p>
                <?php 
                    echo sprintf(
                        __( 'See %s for more information about "SEO SIMPLE PACK".', LOOS_SSP_DOMAIN ), 
                        '<a href="https://wemo.tech/1670" target="_blank">'. __( '"How to use the plugin"', LOOS_SSP_DOMAIN ).'</a>'
                    );
                ?>
            </p>
        </div>
    </div>
</div>
