<div id="main_container">

    <div id="map_overlay">
        <div id="mapdeal" style="right:10px; top:10px; z-index: 99; position: fixed;"></div>
        <div id="changecenter_dialogue" style="left:130px; top:50px; z-index: 99; position: fixed;"></div>
    </div>

    <div id="map_canvas" style="width:100%; height:800px"></div>

</div>


<div style="display: none;">

    <div id="changecenter_dialogue_content" style="background: white; width: 300px; height:50px; padding: 10px;">
        Unable to find any deals near your location.
        Click <a onclick="changeMapCenter(); return false;" href="">here</a> to find more deals.
    </div>

    <div id="mapdeal_content" style="background: white; width: 300px; height:350px; padding: 10px;">
        <a class="mapdeal-url" href=""><p class="mapdeal-title"></p></a>
        <a class="mapdeal-url" href=""><img style="width:200px;height:200px;" class="mapdeal-imgsrc" src=""></a>
        <p class="mapdeal-merchant"></p>
    </div>

</div>