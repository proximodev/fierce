<?php
$colorArray = array("mint", "purple", "blue", "green", "yellow");
if (block_value( 'columns' ) == "four") {
    $colClass="columns-4";
} else {
    $colClass="columns-3";
}

$postCategory = get_query_var('post-category' );

if ($postCategory) {
    $postTerm = get_term_by('slug', $postCategory, 'category');
    $pageTitleH1 = $postTerm->name;
} else {
    $pageTitleH1 = 'Home Run Financing';
}

$attachmentID= block_value( 'banner-image' );
$pageTitleH2 = block_value( 'banner-title' );
?>
<!-- Banner -->
<div class="wp-block-genesis-blocks-gb-container full-width-banner-wrapper green gb-block-container">
   <div class="gb-container-inside">
      <div class="gb-container-content">
         <div class="wp-block-media-text alignfull has-media-on-the-right is-stacked-on-mobile is-image-fill page-banner green">

            <figure class="wp-block-media-text__media" style="background-image:url(https://demo.studiopress.com/page-builder/slate/gb_slate_image_mountain.jpg);background-position:50% 50%">
                <?php if (!$attachmentID): ?>
                    <img src="https://demo.studiopress.com/page-builder/slate/gb_slate_image_mountain.jpg" alt="" class="wp-image-16096 size-full">
                <?php else: ?>
                    <?= wp_get_attachment_image( $attachment_id, 'banner-image' ); ?>
                <?php endif; ?>
            </figure>
            <div class="wp-block-media-text__content">
               <h1 class="parent-section"><?= $pageTitleH1 ?></h1>
               <h2 class="has-white-color has-text-color"><?= $pageTitleH2 ?></h2>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Filters -->
<form method="GET" class="post-filters" id="filter">
	<?php
    if( $terms = get_terms( array( 'taxonomy' => 'category', 'orderby' => 'name' ) ) ) :

        echo '<select id="catfilter" name="post-category">';
        echo '<option value="">All categories</option>';

        foreach ( $terms as $term ) :

            $categorySlug = $term->slug;
            if ($postCategory ==($categorySlug)) {
               echo '<option value="' . $term->slug . '" selected>' . $term->name . '</option>'; // ID of the category as the value of an option
            } else {
                echo '<option value="' . $term->slug . '">' . $term->name . '</option>'; // ID of the category as the value of an option
            }

        endforeach;
        echo '</select>';
    endif;
	?>

	<div class="postsort" style="display:none">
        <strong>Sortby :</strong>
        <label>
            <input type="radio" name="sort" value="date" checked/>Most Recent
        </label>
        <label>
            <input type="radio" name="sort" value="popular" selected="selected" />Most Popular
        </label>
	</div>

	<input type="hidden" name="action" value="myfilter">

</form>

<hr class="wp-block-separator is-style-dots" style="margin-bottom:5px;">

<main id="main" class="content-wrapper">
    <section class="gb-block-post-grid featuredpost aligncenter">
        <div class="gb-post-grid-items is-grid <?= $colClass?>">
        <?php
        // WP_Query arguments
        if($postCategory){
            $args = array (
                'post_type'      => array( 'post' ),
                'post_status'    => array( 'publish' ),
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'category',
                        'field' => 'slug',
                        'terms' => $postCategory,
                    ),
                    'orderby'   => array(
                          'date' =>'DESC',
                    )
                ),
            );

        } else {

            $args = array (
                'post_type'      => array( 'post' ),
                'post_status'    => array( 'publish' ),
                'posts_per_page' => -1,
                'orderby'   => array(
                      'date' =>'DESC',
                )
            );
        }

        // The Query
        $post_query = new WP_Query( $args );
        if ( $post_query->have_posts() ) : ?>
            <?php
            // Start the Loop.
            while ( $post_query->have_posts() ) :
                // You can list your posts here
                $post_query->the_post();
                $color = $colorArray[array_rand($colorArray)];

                ?>

                <article class="gb-post-grid-item">
                   <a href="<?php the_permalink(); ?>" class="post-link"></a>

                   <div class="post-content-wrapper">

                      <div class="post-category">
                         <?php the_category(', '); ?>
                      </div>

                       <div class="gb-block-post-grid-text">
                          <header class="gb-block-post-grid-header">
                             <h3 class="gb-block-post-grid-title">
                                <?php the_title(); ?>
                             </h2>
                          </header>

                          <div class="gb-block-post-grid-excerpt">
                              <?= the_excerpt() ?>
                          </div>
                          <a href="<?php the_permalink(); ?>" class="more-link alt">Read More</a>
                      </div>

                        <div class="gb-block-post-grid-image <?= $color; ?>">
                        </div>

                   </div>

                </article>
                <?php
            endwhile;

        else :
            echo '<strong>We\'re sorry -- no posts match your selection.</strong>';
        endif;
        // Restore original Post Data
        wp_reset_postdata();
        ?>
        </div>
    </section>
</main>


<script>

    jQuery(document).ready(function() {
        jQuery('#catfilter').on('change', function() {
            $catslug = jQuery( "#catfilter option:selected" ).val();
            $reloadURL =  '<?= site_url(); ?>/blog/';
            if ($catslug != "") {
                $reloadURL = $reloadURL + 'category/' + $catslug + '/';
            }
            window.location.href = $reloadURL;
        });

        jQuery('#postsort').on('change', function() {
            jQuery( "#filter" ).submit();
        });

    });

</script>

