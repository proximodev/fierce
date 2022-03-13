<?php
$attachment_id = block_value( 'blog-image' );
$blog_image_custom = wp_get_attachment_image( $attachment_id, 'hero-image' );

$hide_social = block_value( 'hide-social' );
$hide_author = block_value( 'hide-author' );
$blog_date = get_the_date( 'F d, Y' );
if ($hide_social) {
    $nosocial = ' nosocial';
}

$custom_heading = block_value( 'custom-heading' );
$sub_heading = block_value( 'sub-heading' );

// Get the first category
$categories = get_the_category();
if ( ! empty( $categories ) ) {
    $category = esc_html( $categories[0]->name );
}

// Determine image to display
if ($attachment_id) {
    $blog_image = wp_get_attachment_image( $attachment_id, 'hero-image' );
} elseif (has_post_thumbnail() ) {
    $blog_image = get_the_post_thumbnail();
} else {
    $blog_image = "";
}

// Determine headline
if ($custom_heading) {
    $heading = $custom_heading;
} else {
    $heading = esc_html( get_the_title() );
}

?>

<div id="blog-header" class="blog-header-block">

    <div class="blog-image">
    <?= $blog_image ?>
    </div>

    <div class="blog-metadata-wrapper <?= $nosocial; ?>">

        <div class="blog-metadata">
            <?php if ($category): ?>
            <div class="blog-category"><?= $category; ?></div>
            <?php endif; ?>
            <div class="blog-date"><?= $blog_date; ?></div>
        </div>

        <?php if (!$hide_social): ?>
        <div class="blog-social">
            <?php dynamic_sidebar( 'blog_social_icons' ); ?>
        </div>
        <?php endif; ?>

    </div>

    <div class="blog-title">
        <h1><?= $heading; ?></h1>

        <div class="sub-heading">
            <?= $sub_heading; ?>
        </div>

        <?php if (!$hide_author): ?>
            <div class="blog-author">
            By <?php the_author(); ?>
            </div>
        <?php endif; ?>
    </div>

</div>