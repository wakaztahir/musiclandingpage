<?php
/*
Template Name: Link Page Template
Template Post Type: mlp_link
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo the_title(); ?> </title>
    <?php wp_head(); ?>
</head>
<body>
    <?php
        while(have_posts()){
            the_post();

            $release = get_field("release");
            $name = $release->name;
            $desc = $release->description;
            $artist = get_field("artist",$release->taxonomy."_".$release->term_taxonomy_id);
            $type = get_field("type",$release->taxonomy."_".$release->term_taxonomy_id);
            $artwork = get_field("artwork",$release->taxonomy."_".$release->term_taxonomy_id);
            $link = get_field("link");
            $youtube_video_link = get_field("youtube_video_link");
        ?>
    <div class="mlp_container">
        <div class="mlp_background">
            <img src="<?php echo $artwork; ?>" alt="" class="mlp_background_image">
        </div>
        <main class="mlp_content">
            <img src="<?php echo $artwork; ?>" alt="" class="mlp_artwork">
            <div class="mlp_infocard">
                <div class="mlp_info">
                    <span class="mlp_info_heading"><?php echo $artist; ?> - <?php echo $name; ?></span>
                    <span class="mlp_info_desc"><?php echo $desc; ?></span>
                </div>
            </div>
            <div class="mlp_link_section">
                <ul>
                    <?php
                        for($i=0;$i<count($link);$i++){
                            $l = $link[$i];
                            $platform = $l["platform"];
                            $name = $platform=="addnew" ? $l["name"] : $platform;
                            $image = $platform=="addnew" ? $l["image"] : plugin_dir_url(__FILE__)."icons/light/$platform.svg";
                            $url = $l["url"];
                            $buttonText = $l["button_text"];
                            ?>
                            <a href="<?php echo $url ?>"><li>
                                <img src="<?php echo $image ?>" alt="<?php echo $name ?>">
                                <button class="mlp_play_btn"><?php echo $buttonText; ?></button>
                            </li></a>
                            <?php
                        }
                    ?>
                </ul>
            </div>
        </main>
    </div>
    <div class="lonely_space"></div>
    <style> 
    <?php //dynamic styles here ?>
    /* font-family: 'Baloo Tamma 2', cursive;
font-family: 'Raleway', sans-serif;
font-family: 'Roboto', sans-serif; */
    html,body{
        width:100% !important;
        height:100% !important;
        margin:0 !important;
        padding:0 !important;
    }
    .mlp_container{
        width:100%;
        height:100%;
    }
    .mlp_background{
        position: absolute;
        overflow: hidden;
        z-index: -1;
        height: 200%;
        width: 200%;
        top: -50%;
        left: -50%;
        -webkit-transform: translateZ(0);
        transform: translateZ(0);
        background-color: #000;
        display: block;
        position: fixed;
    }
    .mlp_background_image{
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 50%;
        min-width: 55%;
        min-height: 55%;
        margin: auto;
        -webkit-transform: translate3d(-50%,0,0);
        transform: translate3d(-50%,0,0);
        max-width: none;
        -webkit-filter: blur(30px);
        filter: blur(30px);
        opacity: .7;
    }
    .mlp_content{
        width: 320px;
        margin: 0 auto;
        position: relative;
        display:flex;
        flex-direction:column;
    }
    .mlp_artwork{
        width:100%;
        height:100%;
        background:url(<?php echo $artwork; ?>);
        background-size:100%;
    }
    .mlp_infocard{
        width:100%;
        height:85px;
        color:white;
        background:rgb(20,20,20);
        display:flex;
        flex-direction:column;
        align-items:center;
        position:relative;
    }
    .mlp_info{
        text-align:center;  
        margin:0;
    }
    .mlp_info_heading{
        display:inline-block;
        font-family: 'Roboto', sans-serif;
        font-weight:bold;
        font-size:20px;
        margin-top:10px;
    }
    .mlp_info_desc{
        display:block;
        font-size:14px;
        font-family: 'Raleway', sans-serif;
        margin-top:-5px;
    }
    .mlp_infocard::after{
        content:"";
        width:10px;
        height:10px;
        border:10px solid transparent;
        border-top:10px solid rgb(20,20,20);
        position:absolute;
        bottom:-20px;
        z-index:99;
    }
    .mlp_link_section ul{
        list-style:none;
        padding:0;
        margin:0;
    }
    .mlp_link_section ul li{
        background:rgb(250,250,250);
        width:100%;
        height:80px;
        display:flex;
        flex-direction:row;
        align-items:center;
        border-bottom:1px solid rgb(220,220,220);
        transition:background ease 0.3s;
    }
    .mlp_link_section ul li:hover{
        background:rgb(230,230,230);
    }
    .mlp_link_section ul li img{
        float: left;
        margin: 1rem;
        width: 125px;
        height: 40px;
        display:block;
    }
    .mlp_play_btn{
        display:inline-block;
        text-transform:capitalize;
        position:absolute;
        right:1rem;
        background:rgba(255,255,255,.8);
        padding:10px 10px;
        color:#161616;
        border:1px solid rgb(210,210,210);
        font-family: 'Raleway', sans-serif;
        font-size:14px;
        transition:background ease 0.3s,color ease 0.3s;
        border-radius:5px;
    }
    .mlp_link_section ul li:hover .mlp_play_btn{
        color:white;
        background:rgba(40,40,40,.8);
    }
    .lonely_space{
        width:100%;
        height:40px;
    }
    </style>
        <?php
        } 
        wp_footer(false); ?>
<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300&family=Roboto:wght@700&display=swap" rel="stylesheet">
</body>
</html>