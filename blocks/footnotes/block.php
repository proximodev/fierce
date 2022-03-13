<div id="footnotes" class="footnote-block">

    <?php
    $count = 1;
    if ( block_rows( 'footnotes' ) ) : ?>
        <ol>
        <?php while ( block_rows( 'footnotes' ) ) :
        $anchorName ="footnote-" . $count;
        block_row( 'footnotes' );
        ?>
            <li><a name="<?= $anchorName; ?>"></a><?php block_sub_field( 'note' ); ?></h3>
        <?php
        $count = $count +1;
        ?>
        <?php endwhile; ?>
        </ol>
    <?php
    endif;
    reset_block_rows( 'footnotes' );
    ?>
    </div>

</div>

<?php if (block_value( 'display-in-footer' )): ?>
<script>
    jQuery(document).ready(function(){
        jQuery("#footnotes").appendTo(".site-footer");
    });
</script>
<?php endif; ?>