<div class="content-box"><!-- Start Content Box -->
    <div class="content-box-header">
        <h3><?php echo lang($type . '_show') ?></h3>
        <ul class="content-box-tabs">
            <?php if (isset($main_nav) && !empty($main_nav)): ?>
                <?php foreach ($main_nav as $key => $link): ?>
                    <li><a class="current" href="<?php echo $link; ?>"><?php echo lang($key); ?></a></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
        <div class="clear"></div>
    </div>

    <div class="content-box-content">
        <div class="tab-content default-tab" style="display: block;">
            <table>
                <tbody>
                    <?php
                    if (!empty($object)) {
                        foreach ($object as $key => $value) {
                            echo '<tr>';
                            echo '<td class="fwb">' . lang($type . '_' . $key) . '</td>';
                            echo '<td>' . $value . '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
            <div class="clear"></div>

        </div> <!-- End #tab1 -->

    </div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->
