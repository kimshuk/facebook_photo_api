<?php
include('config.txt');

$page_title = "Photo Albums";
?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <title>
            <?php $page_title; ?>
        </title>
        <style>
            .col-md-4 {
                margin: 0 0 2em 0;
            }
            
            .cover-photo img {
                height: 25em;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <?php
                echo "<div class='col-lg-12'>";
                echo "<h1 class='page-header'>{$page_title}</h1>";
                echo "</div>";
            
                $fields="id,name,description,link,cover_photo,count";
            
                $json_link = "https://graph.facebook.com/v2.8/{$fb_page_id}/albums?fields={$fields}&access_token={$access_token}";
                $json = file_get_contents($json_link);
            
                $obj = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);
            
                $album_count = count($obj['data']);
            
                for($x=0; $x<$album_count; $x++) {
                    $id = isset($obj['data'][$x]['id']) ? $obj['data'][$x]['id'] : "";
                    $name = isset($obj['data'][$x]['name']) ? $obj['data'][$x]['name'] : "";

                    $url_name=urlencode($name);
                    $description = isset($obj['data'][$x]['description']) ? $obj['data'][$x]['description'] : "";
                    $link = isset($obj['data'][$x]['link']) ? $obj['data'][$x]['link']: "";

                    //$cover_photo = isset($obj['data'][$x]['cover_photo']) ? $obj['data'][$x]['cover_photo'] : "";
                    //use this for newer access tokens:
                    $cover_photo = isset($obj['data'][$x]['cover_photo']['id']) ? $obj['data'][$x]['cover_photo']['id'] : "";
                    $count = isset($obj['data'][$x]['count']) ? $obj['data'][$x]['count'] : "";

                    //if you want to exclude an album, just add the name on the if statement
                    if(
                        $name!="Profile Pictures" &&
                        $name!="Cover Photos" &&
                        $name!="Timeline Photos"
                    ){
                        $show_pictures_link = "photos.php?album_id={$id}&album_name={$name}";

                        echo "<div class='cover-photo col-xs-12 col-sm-6 col-md-4'>";
                            echo "<a href='{$show_pictures_link}'>";
                                echo "<img class='img-responsive' src='https://graph.facebook.com/v2.8/{$cover_photo}/picture?access_token={$access_token}' alt=''>";
                            echo "</a>";
                            echo "<h3>";
                                echo "<a href='{$show_pictures_link}'>{$name}</a>";
                            echo "</h3>";

                            $count_text = "Photo";
                            if($count>1) { $count_text="Photos"; }

                            echo "<p>";
                                echo "<div style='color:#888'>{$count} {$count_text} / <a href='{$link}' target='_blank'>View on Facebook</a></div>";
                                echo $description;
                            echo "</p>";
                        echo "</div>";
                    }
                }
            ?>
        </div>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    </body>

    </html>