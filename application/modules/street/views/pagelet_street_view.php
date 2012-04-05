<div id="street_overview">
    <?php foreach ($buildings as $building): ?>
        <a href="<?php echo site_url('street/building/' . $building['cell']); ?>" rel="async" ajaxify="<?php echo site_url('ajax/street_ajax/show_building_detail/' . $building['cell']); ?>">
            <div id="<?php echo $building['id']; ?>" class="<?php echo $building['class']; ?>" title="<?php echo $building['name']; ?>">
                <img class="not_hover" src="<?php echo asset_url('images/building/' . $building['image'] . '.png'); ?>" />
                <img class="is_hover" src="<?php echo asset_url('images/building/' . $building['image'] . '_select.png'); ?>" />
            </div>
        </a>
    <?php endforeach; ?>
</div>