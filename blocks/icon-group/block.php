<?php if ( block_rows( 'icons' ) ) : ?>
<div class="icon-group <?php block_field( 'background-style' ); ?>">

    <?php if (!empty(block_value('headline'))): ?>
    <h2 class="has-text-align-center"><?php block_field('headline'); ?></h2>
    <?php endif; ?>

    <?php
    $rowCount = block_row_count( 'icons' );
    $colWidth = (100/$rowCount);
    ?>
    <div class="icon-group-inner">
    <?php while ( block_rows( 'icons' ) ) :
    block_row( 'icons' );
    $iconCode = block_sub_value( 'icon-code' );
    if (empty($iconCode)) {
        $iconCode="<i class=\"fal fa-check\"></i>";
    }
    ?>
        <div class="icon-group-item" style="width:<?= $colWidth ?>%">
            <div class="icon-group-item-icon"><?= $iconCode; ?></div>
            <div class="icon-group-item-text">
                <h3><?php block_sub_field( 'title' ); ?></h3>
                <span><?php block_sub_field( 'description' ); ?></span>
            </div>
        </div>
    <?php endwhile; ?>
    </div>
</div>
<?php
endif;
reset_block_rows( 'icons' );
?>