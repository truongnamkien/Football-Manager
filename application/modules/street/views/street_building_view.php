<div class="content-box">
    <div class="content-box-header">
        <h3><?php echo $name; ?></h3>
    </div>

    <?php if (!empty($building_types)): ?>
        <div class="content-box-content">
            <div id="building_detail_info">
                <div id="building_detail_img">
                    <img class="not_hover" src="<?php echo asset_url('images/building/' . $image . '.png'); ?>" width="240" />
                    <img class="is_hover" src="<?php echo asset_url('images/building/' . $image . '_select.png'); ?>" width="240" />
                </div>

                <?php foreach ($building_types as $building): ?>
                    <div class="building_detail mt10">
                        <?php if (count($building_types) > 1): ?>
                            <h6><?php echo $building['name']; ?></h6>
                        <?php endif; ?>
                        <p>
                            <?php echo $building['description']; ?><br />
                            <span class="fLeft"><?php echo (lang('building_level') . ': '); ?>
                                <span id="street_building_<?php echo $building['street_building_id']; ?>_level">
                                    <?php echo $building['level']; ?>
                                </span>
                            </span><br />
                            <span class="fLeft"><?php echo lang('building_upgrade_fee') . ': ' . $building['fee']; ?></span><br />
                            <a href="#" rel="async" ajaxify="<?php echo site_url('ajax/street_ajax/upgrade/' . $building['street_building_id']); ?>" class="ma5 button fRight"><?php echo lang('building_upgrade'); ?></a>
                        </p>
                    </div>
                    <div class="clear"></div>
                <?php endforeach; ?>
            </div>

            <div class="clear"></div>
        </div>
    <?php endif; ?>
</div>
