<div id="photo_list" class="w595">
    <?php foreach ($format_photos as $key => $line): ?>
        <?php foreach ($line as $key => $photo): ?>
            <div class="fLeft mr10 tac border rounded5 ma10">
                <span class="fLeft pv5 fwb" style="width: 70px;"><?php echo $key; ?></span>
                <div class="clear"></div>
                <img class="fLeft" src="<?php echo $photo; ?>" width="70" />
            </div>
        <?php endforeach; ?>
        <div class="clear"></div>
    <?php endforeach; ?>
</div>
