<div class="content-box"><!-- Start Content Box -->
    <div class="content-box-header">
        <h3><?php echo lang($type . '_create') ?></h3>
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
            <?php if (isset($error_msg) || validation_errors()): ?>
                <div class="notification attention png_bg">
                    <a href="#" class="close"><img src="<?php echo asset_url('images/admin/icons/cross_grey_small.png'); ?>" title="Close this notification" alt="close" /></a>
                    <div>
                        <?php echo (isset($error_msg) ? $error_msg : validation_errors()); ?>
                    </div>
                </div>
            <?php endif ?>

            <table>
                <tbody>
                    <?php
                    echo form_open_multipart('admin/' . $type . '/' . $action . '/' . (isset($id) ? $id : ''));
                    if (isset($form_data)) {
                        foreach ($form_data as $row) {
                            foreach ($row as $key => $value) {
                                echo '<tr>';
                                echo '<td class="fwb">' . $key . '</td>';
                                echo '<td>' . $value . '</td>';
                                echo '</tr>';
                            }
                        }
                    }
                    ?>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input class="button" type="submit" value="<?php echo lang($type . '_' . $action . '_submit'); ?>" /></td>
                    </tr>
                    <?php echo form_close(); ?>
                </tbody>
            </table>
            <div class="clear"></div>
        </div>
    </div>
</div>
