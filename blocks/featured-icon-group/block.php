<div class="featured-icon-group full-width-gray-gradient">
    <div class="featured-icon-group-inner">
        <div class="featured-icon-group-text-column">
            <h2><?php block_field( 'title' ); ?></h2>
            <?php if (block_value( 'description' )): ?>
            <div class="featured-icon-description"><?php block_field( 'description' ); ?></div>
            <?php endif; ?>
            <?php if (block_value( 'link-type' ) == "Video"): ?>
            <div class="wp-block-buttons video">
                <div class="wp-block-button"><a class="wp-block-button__link vp-a" href="<?php block_field( 'button-url' ); ?>"><?php block_field( 'button-label' ); ?></a></div>
            </div>
            <?php else: ?>
            <div class="wp-block-buttons">
                <div class="wp-block-button"><a class="wp-block-button__link" href="<?php block_field( 'button-url' ); ?>"><?php block_field( 'button-label' ); ?></a></div>
            </div>
            <?php endif; ?>

        </div>
        <div class="featured-icon-group-icon-column">
            <?php if ( block_rows( 'icons' ) ) : ?>
                <?php
                $rowCount = block_row_count( 'icons' );
                $colWidth = "50";
                ?>
                    <?php while ( block_rows( 'icons' ) ) :
                    block_row( 'icons' );
                    $iconCode = block_sub_value( 'icon-code' );
                    if (empty($iconCode)) {
                        $iconCode="<i class=\"fal fa-check\"></i>";
                    }
                    $iconURL = block_sub_value( 'icon-url' );
                    ?>
                    <div class="featured-icon-group-item" style="width:<?= $colWidth ?>%">
                        <div class="featured-icon-group-item-icon"><?= $iconCode; ?></div>
                        <div class="featured-icon-group-item-text">
                            <h3><?php block_sub_field( 'title' ); ?></h3>
                            <div class="icon-description"><?php block_sub_field( 'description' ); ?></div>
                        </div>
                        <?php if ($iconURL): ?>
                        <a href="<?= $iconURL; ?>"><span class="iconLink"></span></a>
                        <?php endif; ?>
                    </div>
                    <?php endwhile; ?>
            <?php
            endif;
            reset_block_rows( 'icons' );
            ?>
        </div>
    </div>
</div>