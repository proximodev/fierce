<!-- Header -->
<div class="wp-block-group comparison-table-intro">
    <div class="wp-block-group__inner-container">
        <h2 class="has-text-align-center"><?php block_field( 'title' ); ?></h2>
        <?php if (block_value( 'description' )): ?>
        <div class="has-text-align-center"><p><?php block_field( 'description' ); ?></p></div>
        <?php endif; ?>
    </div>
</div>

<!-- Table Wrapper -->
<div class="full-width-gray comparison-table-wrapper">

<?php
/** Define styles **/
$tableStyle = (block_value( 'style' ));
if ($tableStyle == "green") {
    $tableFirstClass=" bg-green";
    $tableAltClass=" bg-green";
} elseif ($tableStyle == "gray") {
    $tableFirstClass=" bg-gray";
    $tableAltClass=" bg-gray";
} else {
    $tableFirstClass=" bg-important";
    $tableAltClass=" bg-gray";
}

/** Get Tables **/
if ( block_rows( 'tables' ) ):
    $tableData = array();
    $rowCount = block_row_count( 'tables' );
    while ( block_rows( 'tables' ) ) :
    block_row( 'tables' );
        $tableData[] = array(
            block_sub_value( 'title' ),
            block_sub_value( 'value-1' ),
            block_sub_value( 'value-2' ),
            block_sub_value( 'value-3' ),
            block_sub_value( 'value-4' ),
            block_sub_value( 'value-5' ),
            block_sub_value( 'value-6' ),
            block_sub_value( 'value-7' ),
            block_sub_value( 'value-8' ),
            block_sub_value( 'value-9' ),
            block_sub_value( 'value-10' )
        );
    endwhile;

    /** Calc column widths **/
    $tableDataCount = count($tableData);
    $mobileButtonWidth = (100/$tableDataCount);

    if ($tableDataCount < "3") {
        $colWidth = (70/$tableDataCount);
    } else {
        $colWidth = (83/$tableDataCount);
    }

    if ($tableStyle == "default") {
        $colWidthImportant = $colWidth +5;
    } else {
        $colWidthImportant = $colWidth;
    }

    ?>

    <article class="comparison-table">

        <ul>
            <?php if ($tableDataCount > 0): ?>
            <li class="active<?= $tableFirstClass ?>">
                <button><?= $tableData[0][0]; ?></button>
            </li>
            <?php endif; ?>
            <?php if ($tableDataCount > 1): ?>
            <li class="<?= $tableAltClass ?>">
                <button><?= $tableData[1][0]; ?></button>
            </li>
            <?php endif; ?>
            <?php if ($tableDataCount > 2): ?>
            <li class="<?= $tableAltClass ?>">
                <button><?= $tableData[2][0]; ?></button>
            </li>
            <?php endif; ?>
            <?php if ($tableDataCount > 3): ?>
            <li class="<?= $tableAltClass ?>">
                <button><?= $tableData[3][0]; ?></button>
            </li>
            <?php endif; ?>
        </ul>

        <table>
            <thead>
            <tr>
                <th class="hide"></th>
                <?php if ($tableDataCount > 0): ?>
                <th class="default<?= $tableFirstClass ?>" style="width: <?= $colWidthImportant; ?>%;"><div><span><?= $tableData[0][0]; ?></span></div></th>
                <?php endif; ?>
                <?php if ($tableDataCount > 1): ?>
                <th class="<?= $tableAltClass ?>" style="width: <?= $colWidth ?>%;"><span><?= $tableData[1][0]; ?></span></th>
                <?php endif; ?>
                <?php if ($tableDataCount > 2): ?>
                <th class="<?= $tableAltClass ?>" style="width: <?= $colWidth ?>%;"><span><?= $tableData[2][0]; ?></span></th>
                <?php endif; ?>
                <?php if ($tableDataCount > 3): ?>
                <th class="<?= $tableAltClass ?>" style="width: <?= $colWidth ?>%;"><span><?= $tableData[3][0]; ?></span></th>
                <?php endif; ?>
            </tr>
            </thead>
            <tbody>

        <?php
        /** Get Table Labels **/
        if ( block_rows( 'row-labels' ) ):
            $x = 1;
            while ( block_rows( 'row-labels' ) ) :
            block_row( 'row-labels' );
            ?>
            <tr>
                <td><?php block_sub_field( 'label-name' ); ?></td>
                <?php if ($tableDataCount > 0): ?>
                <td class="<?php if($tableStyle=="default") { echo "bg-important"; } ?> default">
                    <div><?= $tableData[0][$x]; ?></div>
                </td>
                <?php endif; ?>
                <?php if ($tableDataCount > 1): ?>
                <td>
                    <div><?= $tableData[1][$x]; ?></div>
                </td>
                <?php endif; ?>
                <?php if ($tableDataCount > 2): ?>
                <td>
                    <div><?= $tableData[2][$x]; ?></div>
                </td>
                <?php endif; ?>
                <?php if ($tableDataCount > 3): ?>
                <td>
                    <div><?= $tableData[3][$x]; ?></div>
                </td>
                <?php endif; ?>
            </tr>

            <?php
            $x++;
            endwhile;

            $closeTag = '<tr><td></td>';
            for ($x = 0; $x < $tableDataCount; $x++) {
                $closeTag .= "<td></td>";
            }
            $closeTag .= "</tr>";
            echo $closeTag;

        else:
            echo 'This table is missing label data.';
        endif;
        reset_block_rows( 'row-labels' );

            ?>

            </tbody>
        </table>

        <?php if (!empty(block_value('footnote'))): ?>
        <div class="table-footnote">
            <?php block_field( 'footnote' ); ?>
        </div>
        <?php endif; ?>

        <?php if (!empty(block_value('button-label'))): ?>
        <div class="wp-block-buttons">
            <div class="wp-block-button"><a class="wp-block-button__link" href="<?php block_field( 'button-url' ); ?>"><?php block_field( 'button-label' ); ?></a></div>
        </div>
        <?php endif; ?>

    </article>
    <?php
else:
    echo 'This table has no data.';
endif;
reset_block_rows( 'tables' );

?>

</div>