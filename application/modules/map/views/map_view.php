    
<div id="text_out">
    aaaaa
</div>


<style type="text/css">
    .backgroundmap {
        position: relative;
        width: 400px;
        height: 200px;
        background-color: #ccc;
        border: 1px solid #000;
    }
    
</style>

<a id="map_excute" href="javascript:void('0');" ajaxify="" rel="async">  </a>
<div>
    <img id="tag_map" src="<?php echo asset_url('images/map/directions.gif'); ?>" usemap="#tag_map_overflow" height="135" width="130">
        <map name="tag_map_overflow" id="tag_map_overflow">
                <area id="center" shape="circle" coords="64,66,24" href="javascript:void('0');" >
                <area id="west" shape="poly" coords="0,0,35,0,55,45,44,58,0,40" href="javascript:void('0');">
                <area id="north_west" shape="poly" coords="35,0,90,0,75,45,55,45" href="javascript:void('0');">
                <area id="north" shape="poly" coords="90,0,130,0,130,40,88,58,75,45" href="javascript:void('0');">
                <area id="north_east" shape="poly" coords="130,40,130,95,87,78,87,58" href="javascript:void('0');">
                <area id="east" shape="poly" coords="130,95,130,130,90,130,75,88,85,78" href="javascript:void('0');">
                <area id="south_east" shape="poly" coords="90,130,38,130,55,88,75,88" href="javascript:void('0');">
                <area id="south" shape="poly" coords="38,130,0,130,0,95,40,76,55,88" href="javascript:void('0');">
                <area id="south_west" shape="poly" coords="0,95,0,40,40,58,40,76" href="javascript:void('0');">
        </map>
    </img>
</div>
<div id="map_body">
    <div >
    <?php if (isset($streets)): ?>
        <div id="NavMapCoat02" style="">
            <input id="map_x" size="5" style="top: 7px; left: 36px; width: 28px; height: 18px;" value="<?php echo $x_coor ?>">
            <input id="map_y" size="5" style="top: 7px; left: 81px; width: 28px; height: 18px;" value="<?php echo $y_coor ?>">
            <a href="javascript:map_goto();"><img src="<?php echo asset_url('images/map/MapGo.gif'); ?>" style="left: 117px; top: 5px;"></a>
            <a href="javascript:map_go_current_city();"><img src="<?php echo asset_url('images/map/MapBack.gif'); ?>" style="left: 141px; top: 5px;"></a>
        </div>
        <?php   $width = Street_model::AREA_WIDTH * Street_model::CELL_WIDTH; 
                $height = Street_model::AREA_HEIGHT * Street_model::CELL_HEIGHT;
        ?>
        <div style="width:<?php echo $width ?>px;height:<?php echo $height ?>px;margin-left:0px;position:absolute;overflow:hidden;">
            <div id="drag_zone" style="position: absolute; left: 0px; width: 2268px; height: 1344px; top: 0px;">
                <?php for ($i = 0; $i < Street_model::AREA_WIDTH; $i++): ?>
                    <?php for ($j = 0; $j < Street_model::AREA_HEIGHT; $j++): ?>
                        <?php if (isset($streets[$j][$i])): ?>
                            <a href="<?php echo site_url('street/index?street_id=' . $streets[$j][$i]['street_id']) ?>"><img id="i_<?php echo $i.$j?>" src="<?php echo asset_url('images/map/player.gif'); ?>" style="position:absolute; left: <?php echo $i * 64?>px; top: <?php echo $j * 64?>px;" onclick="alert('Click Image')"></a>
                        <?php
                        else:
                            $x = $x_coor + $i;
                            $y = $y_coor + $j;
                        ?>
                            <a href="<?php echo site_url('street/empty?x_coor=' . $x . '&y_coor=' . $y) ?>"><img id="i_<?php echo $i.$j?>" src="<?php echo asset_url('images/map/empty.gif'); ?>" style="position:absolute; left: <?php echo $i * 64?>px; top: <?php echo $j * 64?>px;" onclick="alert('Click Image')"></a>
                        <?php endif; ?>
                    <?php endfor; ?>
                <?php endfor; ?>
            </div>
        </div>
        
        <div id="backgroundcontent" onmousedown="setMapMouseDown(this,event);" style="background-image:url(<?php echo asset_url('images/map/blank.gif'); ?>); ">
<!--            <div id="map_over" style="background: url(<?php echo asset_url('images/map/empty.gif'); ?>) repeat scroll 0% 0% transparent; position: absolute; left: 189px; top: 29px; width: 129px; height: 87px;"></div>-->
            <div id="map_seletect" onmousedown="setMapMouseDown(this,event);" style="background:url(<?php echo asset_url('images/map/over.gif'); ?>) repeat scroll 0% 0% transparent; position:absolute;width:<?php echo $width ?>px;height:<?php echo $height ?>px;" class="backgroundmap"></div>
        </div>
    <?php endif; ?>
    </div>
<div>

    
<script>
    var dragMap = document.getElementById("drag_zone");
    var dragging;
    var coord = []; 
    coord['x_coord'] = <?php echo $x_coor?>;
    coord['y_coord'] = <?php echo $y_coor?>;
    var org_city_coord = [];
    org_city_coord['x'] = coord['x_coord'];
    org_city_coord['y'] = coord['y_coord'];
    url_ajax = "<?php echo site_url('ajax/map_ajax/upgrade?')?>";

    $(document).ready(function() {
        document.ondragstart=function(e) { 
            return false; 
        }
        
        $("area").click(function(){
            map_update_coord((this).id);
            map_goto_xy(coord['x_coord'], coord['y_coord']);
        }
        );
      
    });
    
    function map_goto_xy(x, y)
    {
        var coord_value = "x_coor=" + x + "&y_coor=" + y;
        var ajax_value = url_ajax + coord_value;
        $('#map_excute').attr('ajaxify', ajax_value);
//        $('#map_excute').html(ajax_value);
        $('#map_excute').click();
    }
    function map_goto()
    {
        map_goto_xy($('#map_x').val(), $('#map_y').val());
    }
    

    function map_go_current_city()
    {
        map_goto_xy(org_city_coord['x'], org_city_coord['y']);
    }
//    function setMapMouseDown(element, event){
//        if(dragging) return;
//
//        dragging=true;
//        
//        var d=document.body;
//        if(!event)event=window.event;
//        dragMap.start_x=event.clientX;
//        dragMap.start_y=event.clientY;
//        
//        dragMap.orig_x=parseInt(dragMap.style.left) - document.body.scrollLeft;
//        dragMap.orig_y=parseInt(dragMap.style.top) - document.body.scrollTop;
//        dragMap.m_pos_x = event.clientX+d.scrollLeft-dragMap.offsetLeft;
//        dragMap.m_pos_y = event.clientY+d.scrollTop-dragMap.offsetTop;
//
//        dragMap.tmp_mousemove=d.onmousemove;
//        dragMap.tmp_mouseup=d.onmouseup;
//        dragMap.tmp_dragstart=d.ondragstart;
//        dragMap.tmp_selectstart=d.onselectstart;
//        dragMap.tmp_select=d.onselect;
//        
//        d.ondragstart = "return false;"
//        d.onselectstart = "return false;"
//        d.onselect = "document.selection.empty();"
//        if(element.setCapture)
//                element.setCapture();
//        else if(window.captureEvents)
//                window.captureEvents(Event.MOUSEMOVE|Event.MOUSEUP);
//        var start = new Date().getTime();
//        d.onmousemove = function(event)
//        {
//                if(dragging)
//                {
//                        if(!event)event=window.event;
//                        var l=event.clientX+document.body.scrollLeft-dragMap.m_pos_x;
//                        var t=event.clientY+document.body.scrollTop-dragMap.m_pos_y;
//                        dragMap.style.left = l + "px";
//                        dragMap.style.top = t + "px";
//                        dragMap.orig_x = parseInt(dragMap.style.left) - document.body.scrollLeft;
//                        dragMap.orig_y = parseInt(dragMap.style.top) - document.body.scrollTop;
////                        alert(" 222222222222222 ");
//                }
//                else
//                {
////                        dragMapOverFlow.style.cursor = "normal";
//                }
//        }
//
//        d.onmouseup = function(event)
//        {
//                //Check time click
//                var elapsed = new Date().getTime() - start;
//                $('#text_out').html(elapsed);
//                dragging=false;
//                if(!event)event=window.event;
////                dragMapOverFlow.style.cursor = "normal";
//                dragMap.style.display="none";
//                //dragMap.style.left=dragMapOverFlow.style.left;
//                //dragMap.style.top=dragMapOverFlow.style.top;
//                dragMap.style.zIndex = dragMap.orig_index;
//                dragMap.style.display="";
//                if(element.releaseCapture)
//                        element.releaseCapture();
//                else if(window.captureEvents)
//                        window.captureEvents(Event.MOUSEMOVE|Event.MOUSEUP);
//
//                //dragMapSelect.style.zIndex=dragMapOverFlow.style.zIndex-1;
//
//                d.onmousemove = dragMap.tmp_mousemove;
//                d.onmouseup = dragMap.tmp_mouseup;
//                d.ondragstart = dragMap.tmp_dragstart;
//                d.onselectstart = dragMap.tmp_selectstart;
//                d.onselect = dragMap.tmp_select;
//
//                var tile_width=125;
//                var tile_height=58;
//                var deltaTileX=(event.clientX-dragMap.start_x)/tile_width;
//                var deltaTileY=(event.clientY-dragMap.start_y)/tile_height;
//                var delta_world_x=Math.round(deltaTileX+deltaTileY);
//                var delta_world_y=Math.round(deltaTileX-deltaTileY);
//                if(delta_world_x!=0 || delta_world_y!=0)
//                {
//                        world_x -= delta_world_x;
//                        world_y -= delta_world_y;
////                            new GameAjax("app:map:go", {x:world_x,y:world_y,cid:character.id,aid:character.ally_id},drag_map_over);
//                }else {
//                    dragMap.style.left=(0-((m_width)*2*IMG_WIDHT_M))+"px";
//                    dragMap.style.top=(0-((m_height)*IMG_HEIGHT_M))+"px";
//                }
//                
//        }
//    };
    
    function map_update_coord($direction) 
    {
        switch($direction)
        {
            case "center":
                coord['x_coord'] = org_city_coord['x'];
                coord['y_coord'] = org_city_coord['y'];
                break;
            
            case "east":
                coord['x_coord'] = coord['x_coord'] + 5;
                coord['y_coord'] = coord['y_coord'];
                break;
            
            case "west":
                coord['x_coord'] = coord['x_coord'] - 5;
                coord['y_coord'] = coord['y_coord'];
                break;
            
            case "south":
                coord['x_coord'] = coord['x_coord'];
                coord['y_coord'] = coord['y_coord'] - 5;
                break;
            
            case "north":
                coord['x_coord'] = coord['x_coord'];
                coord['y_coord'] = coord['y_coord'] + 5;
                break;
            
            case "north_east":
                coord['x_coord'] = coord['x_coord'] + 5;
                coord['y_coord'] = coord['y_coord'] + 5;
                break;
            
            case "north_west":
                coord['x_coord'] = coord['x_coord'] - 5;
                coord['y_coord'] = coord['y_coord'] + 5;
                break;
            
            case "south_west":
                coord['x_coord'] = coord['x_coord'] - 5;
                coord['y_coord'] = coord['y_coord'] - 5;
                break;
            
            case "south_east":
                coord['x_coord'] = coord['x_coord'] + 5;
                coord['y_coord'] = coord['y_coord'] - 5;
                break;
        };
    };
</script>