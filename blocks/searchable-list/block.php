<div class="list-search">

    <input type="search" class="list-search" id="filter" placeholder="<?php block_field( 'search-placeholder-text' ); ?>">

    <div class="search-content">
    <?php if ( block_rows( 'lists' ) ) : ?>
        <?php while ( block_rows( 'lists' ) ) :
        block_row( 'lists' );
        ?>

        <ul>
            <li class="active"><h3><?php block_sub_field( 'list-heading' ); ?></h3>
            <?php block_sub_field( 'list-items' ); ?>
        </ul>

        <?php endwhile; ?>
    <?php else: ?>
        <p>No items were found. Please add a list.</p>
    <?php
    endif;
    reset_block_rows( 'lists' );
    ?>
    </div>

    <div class="wp-block-buttons">
        <div class="wp-block-button"><a class="wp-block-button__link" href="<?php block_field( 'button-URL' ); ?>"><?php block_field( 'button-label' ); ?></a></div>
    </div>

    <div class="no-results">
        <?php block_field( 'no-results-message' ); ?>
    </div>

</div>

<script>

</script>
