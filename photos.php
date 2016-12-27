<?php
include('config.txt');

$album_id = isset($_GET['album_id']) ? $_GET['album_id'] : die('Album ID not specified.');
$album_name = isset($_GET['album_name']) ? $_GET['album_name'] : die('Album name not specified.');

$page_title = "{$album_name} Photos";
?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title>
            <?php echo $page_title; ?>
        </title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
        <link rel="stylesheet" href="css/blueimp-gallery.min.css">
        <style>
            .photo-thumb {
                width: 214px;
                height: 214px;
                float: left;
                border: thin solid #d1d1d1;
                margin: 0 1em 1em 0;
            }
            
            div#blueimp-gallery div.modal {
                overflow: visible;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <?php
                echo "<h1 class='page-header'>";
                    echo "<a href='index.php'>Albums</a> / {$page_title}";
                echo "</h1>";

                $json_link = "https://graph.facebook.com/v2.8/{$album_id}/photos?fields=source,images,name&access_token={$access_token}";
                $json = file_get_contents($json_link);
            
                $obj = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);
                $photo_count = count($obj['data']);
            
                for($x=0; $x<$photo_count; $x++){
 
                    // $source = isset($obj['data'][$x]['source']) ? $obj['data'][$x]['source'] : "";
                    $source = isset($obj['data'][$x]['images'][0]['source']) ? $obj['data'][$x]['images'][0]['source'] : ""; //hd image
                    $name = isset($obj['data'][$x]['name']) ? $obj['data'][$x]['name'] : "";
                    
                    echo "<a href='{$source}' data-gallery>";
                    echo "<div class='photo-thumb' style='background: url({$source}) 50% 50% no-repeat;'>";
 
                    echo "</div>";
                    echo "</a>";

                }
            ?>

        </div>

        <!-- The Gallery as lightbox dialog, should be a child element of the document body -->
        <div id="blueimp-gallery" class="blueimp-gallery">
            <div class="slides"></div>
            <h3 class="title"></h3>
            <a class="prev">‹</a>
            <a class="next">›</a>
            <a class="close">×</a>
            <a class="play-pause"></a>
            <ol class="indicator"></ol>
            <!-- The modal dialog, which will be used to wrap the lightbox content -->
            <div class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" aria-hidden="true">&times;</button>
                            <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body next"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left prev">
                                <i class="glyphicon glyphicon-chevron-left"></i> Previous
                            </button>
                            <button type="button" class="btn btn-primary next">
                                Next
                                <i class="glyphicon glyphicon-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
        <script src="js/blueimp-gallery.min.js"></script>
        <script>
            $('#blueimp-gallery').data('useBootstrapModal', false);
            $('#blueimp-gallery').toggleClass('blueimp-gallery-controls', true);
        </script>
    </body>

    </html>