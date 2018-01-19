<style type="text/css">
    .wrap-elm{
        margin-bottom: 20px;
    }
    .wrap-elm ul{
        list-style: none;
        margin: 0 0 20px;
        padding: 0;
        min-height: 30px;
    }
    .wrap-elm ul li{
        margin: 5px;
        padding: 5px;
        border:1px solid #bebebe;
        background: #EEEEEE;
        display: inline-block;
    }
    .drag-elm{
        border: 1px solid #009966;
    }
    .drag-over{
        border: 2px dashed #009966;
    }
</style>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript">
    $(function(){
        $(".wrap-elm ul li").each(function(){
            $(this).draggable({
                cursor: "move",
                helper: "clone",
                revert: "invalid"
            });
        });
        $('.wrap-elm ul').each(function(){
            $(this).droppable({
                accept: ".wrap-elm ul li",
                hoverClass: "drag-over",
                drop: function( event, ui ) {
                    ui.draggable.appendTo(this);
                    get_save_string();
                }
            });
        });
        function get_save_string(){
            var saveString = "{";
            var mainContainer = document.getElementById('elm-save-content');
            var uls = mainContainer.getElementsByTagName('UL');
            for(var no=0;no<uls.length;no++){	// LOoping through all <ul>
                var lis = uls[no].getElementsByTagName('LI');
                saveString += '"' + uls[no].id + '": [';
                for(var no2=0;no2<lis.length;no2++){
                    if(lis[no2].id.length > 0){
                        if(no2 == lis.length -1){
                            saveString += '{"term_id":' + lis[no2].id + '}';
                        }else{
                            saveString += '{"term_id":' + lis[no2].id + '},';
                        }
                    }
                }
                if(no == uls.length -1){
                    saveString += ']';
                }else{
                    saveString += '],';
                }

            }
            saveString += "}";

            document.getElementById('saveContent').value = saveString;
        }
        $(window).load(function(){
            get_save_string();
        });
    });
</script>
<div class="wrap">
    <div class="opwrap" style="margin-top: 10px;" >
        <div class="icon32" id="icon-options-general"></div>
        <h2 class="wraphead"><?php echo THEME_NAME; ?> home options</h2>
        <?php
        if (isset($_REQUEST['saved']))
            echo '<div id="message" class="updated fade"><p><strong>' . THEME_NAME . ' settings saved.</strong></p></div>';
            $taxonomy = 'product_category';
            $categories = get_categories(array(
                'type' => 'product',
                'taxonomy' => $taxonomy,
                'hide_empty' => false,
            ));
        ?>
        <form method="post">
            <table class="form-table" cellpadding="3" cellspacing="0">
                <tr>
                    <td>
                        <div class="wrap-elm">
                            <p>Available categories</p>
                            <ul class="drag-elm">
                                <?php
                                foreach ($categories as $category) {
                                    echo "<li id=\"{$category->term_id}\">{$category->name}</li>";
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="wrap-elm" id="elm-save-content">
                            <p>Home categories</p>
                            <ul class="drag-elm" id="box1">
                                <?php
                                $boxArr = json_decode(get_option('cat_box1'));
                                if(count($boxArr) > 0){
                                    foreach ($boxArr as $catID) {
                                        $category = get_term($catID, $taxonomy);
                                        echo "<li id=\"{$category->term_id}\">{$category->name}</li>";
                                    }
                                }
                                ?>
                            </ul>
                            <input type="hidden" name="saveContent" id="saveContent" value="" />
                        </div>
                    </td>
                </tr>
            </table>
            <div class="submit" style="margin-left: 10px;">
                <input name="save" type="submit" value="Save changes" class="button button-large button-primary" />
                <input type="hidden" name="action" value="save" />
            </div>
        </form>
    </div>
</div>