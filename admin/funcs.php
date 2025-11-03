<?php

add_action('acf/save_post', 'save_post', 20);

function calculate_reading_time($content)
{
    $words = str_word_count(strip_tags($content));
    $minutes = ceil($words / 200); // Assuming an average reading speed of 200 words per minute
    if ($minutes < 1) {
        $minutes = 1;
    }
    //$reading_time = $minutes . ' minuto' . ($minutes == 1 ? '' : 's') . ' leitura';
    $reading_time = $minutes . ' min' . ' leitura';
    return $reading_time;
}

function save_post($post_id)
{
    $posttype = get_post_type($post_id);

    if ($posttype == 'noticia' || $posttype == 'opiniao') {
        $post_content = get_field('conteudo', $post_id);
        $post_sinopse = get_field('sinopse', $post_id);
        $reading_time = calculate_reading_time($post_content);
        $post_args = array('post_content' => $post_sinopse);
        wp_update_post($post_args, true);
        update_field('reading_time', $reading_time, $post_id);
    }
}

function countPostViews($postID)
{
    if (!is_user_logged_in()) {
        $count = (float) get_field('visualizacoes', $postID);
        $count = $count + 0.5;
        update_field('visualizacoes', $count, $postID);
    }
}

function GetStory()
{
    $the_query = new WP_Query(array(
        'post_type' => 'story',
        'orderby'   => 'rand',
        'posts_per_page' => 1,
    ));

    $result = array();

    if ($the_query->have_posts()) {
        while ($the_query->have_posts()) {
            $the_query->the_post();
            $answers = get_field('answer', get_the_ID());
            $answersArr = array();

            foreach($answers as $answer) {
                array_push($answersArr, array('image' => $answer['image']));
            }

            $result = array(
                'gameid' => get_the_ID(),
                'background_image_desktop' => get_field('background_image_desktop', get_the_ID()),
                'background_image_mobile' => get_field('background_image_mobile', get_the_ID()),
                'texts' => get_field('texts', get_the_ID()),
                'final_screen' => get_field('final_screen', get_the_ID()),
                'answers' => $answersArr,
            );
        }
    }

    return $result;
}


/*$args = array(
    'post_type' => array('noticia', 'opiniao'),
    'posts_per_page' => -1,
);

$posts = get_posts($args);

foreach ($posts as $post) {
    $post_content = get_field('conteudo', $post->ID);
    $post->post_content = $post_content;
    $reading_time = calculate_reading_time($post_content);
    update_field('reading_time', $reading_time, $post->ID);
    wp_update_post();
}*/