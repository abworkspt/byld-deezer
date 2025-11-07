<?php

$services = array('abw_submit_participant');

foreach ($services as $service) {
    add_action("wp_ajax_nopriv_{$service}", "{$service}");
    add_action("wp_ajax_{$service}", "{$service}");
}

function abw_submit_participant()
{
    if (! isset($_POST['_wpnonce']) || ! wp_verify_nonce($_POST['_wpnonce'], 'abw_participant_nonce')) {
        wp_send_json_error(['message' => 'Nonce invalide.'], 400);
    }

    if (!empty($_POST['website'])) {
        wp_send_json_error(['message' => 'Détection de spam.'], 400);
    }

    // Sanitização
    $last_name   = sanitize_text_field($_POST['nome'] ?? '');
    $first_name  = sanitize_text_field($_POST['apelido'] ?? '');
    $email       = sanitize_email($_POST['email'] ?? '');
    $contact     = sanitize_text_field($_POST['telefone'] ?? '');
    $birth       = sanitize_text_field($_POST['nascimento'] ?? '');
    $city        = sanitize_text_field($_POST['cidade'] ?? '');
    $group_name  = sanitize_text_field($_POST['grupo'] ?? '');
    $style       = sanitize_text_field($_POST['estilo'] ?? '');
    $instagram   = sanitize_text_field($_POST['instagram'] ?? '');
    $deezer      = esc_url_raw($_POST['deezer'] ?? '');
    $description = sanitize_textarea_field($_POST['description_groupe'] ?? '');
    $consent     = !empty($_POST['consent']);

    // Validações mínimas (server-side)
    $errors = [];
    if (!$last_name || !$email || !$contact || !$birth || !$consent) $errors[] = 'Champs obligatoires manquants.';
    if ($email && !is_email($email)) $errors[] = 'Email invalide.';

    $age = null;
    if ($birth) {
        $ts  = strtotime($birth);
        if ($ts) {
            $now = new DateTime();
            $bd = (new DateTime())->setTimestamp($ts);
            $age = (int)$now->diff($bd)->y;
            if ($age < 16 || $age > 120) $errors[] = 'Âge minimum 16 ans.';
        } else {
            $errors[] = 'Date de naissance invalide.';
        }
    }

    // Uploads
    $photo_ids = [];
    if (!empty($_FILES['fotos']['name'][0])) {
        $allowed = ['image/jpeg', 'image/png'];
        $max     = 10 * 1024 * 1024;
        $count   = count(array_filter($_FILES['fotos']['name']));
        if ($count > 5) $errors[] = 'Maximum 5 photos.';

        foreach ($_FILES['fotos']['name'] as $i => $n) {
            if (!$_FILES['fotos']['name'][$i]) continue;
            if (!in_array($_FILES['fotos']['type'][$i], $allowed, true)) {
                $errors[] = 'Seulement JPG/PNG.';
                break;
            }
            if ($_FILES['fotos']['size'][$i] > $max) {
                $errors[] = 'Chaque fichier doit être < 10 Mo.';
                break;
            }
        }
    }

    if ($errors) {
        wp_send_json_error(['message' => implode(' ', $errors)], 422);
    }

    // Verificação por email (bloquear duplicados)
    if ($email) {
        $existing = get_posts([
            'post_type'      => 'participant',
            'post_status'    => ['publish', 'pending', 'draft'],
            'posts_per_page' => 1,
            'meta_query'     => [
                [
                    'key'     => 'email',
                    'value'   => $email,
                    'compare' => '=',
                ],
            ],
        ]);

        if (!empty($existing)) {
            wp_send_json_error(['message' => 'Une participation avec cet e-mail existe déjà.'], 409);
        }
    }

    // Criar post
    $post_id = wp_insert_post([
        'post_type'   => 'participant',
        'post_status' => 'publish',
        'post_title'  => trim($last_name . ' ' . $first_name),
    ]);

    if (is_wp_error($post_id)) {
        wp_send_json_error(['message' => 'Erreur lors de la création du participant.'], 500);
    }

    // Processar uploads e recolher IDs
    if (!empty($_FILES['fotos']['name'][0])) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';

        foreach ($_FILES['fotos']['name'] as $i => $name) {
            if (!$_FILES['fotos']['name'][$i]) continue;
            $_FILES['__foto_single'] = [
                'name'     => $_FILES['fotos']['name'][$i],
                'type'     => $_FILES['fotos']['type'][$i],
                'tmp_name' => $_FILES['fotos']['tmp_name'][$i],
                'error'    => $_FILES['fotos']['error'][$i],
                'size'     => $_FILES['fotos']['size'][$i],
            ];
            $att_id = media_handle_upload('__foto_single', $post_id);
            if (!is_wp_error($att_id)) $photo_ids[] = $att_id;
        }
    }

    // Mapear para ACF (usa os NAMES da tua captura)
    if (function_exists('update_field')) {
        update_field('last_name',           $last_name,   $post_id);
        update_field('first_name',          $first_name,  $post_id);
        update_field('email',               $email,       $post_id);
        update_field('contact',             $contact,     $post_id);
        update_field('age',                 $age,         $post_id);
        update_field('city',                $city,        $post_id);
        update_field('group_name',          $group_name,  $post_id);
        update_field('musical_style',       $style,       $post_id);
        update_field('instagram_account',   $instagram,   $post_id);
        update_field('deezer_link',         $deezer,      $post_id);
        update_field('description_groupe',  $description, $post_id);
        if ($photo_ids) update_field('photos', $photo_ids, $post_id);
    } else {
        // fallback sem ACF (grava como post meta normal)
        update_post_meta($post_id, 'last_name',          $last_name);
        update_post_meta($post_id, 'first_name',         $first_name);
        update_post_meta($post_id, 'email',              $email);
        update_post_meta($post_id, 'contact',            $contact);
        update_post_meta($post_id, 'age',                $age);
        update_post_meta($post_id, 'city',               $city);
        update_post_meta($post_id, 'group_name',         $group_name);
        update_post_meta($post_id, 'musical_style',      $style);
        update_post_meta($post_id, 'instagram_account',  $instagram);
        update_post_meta($post_id, 'deezer_link',        $deezer);
        update_post_meta($post_id, 'description_groupe', $description);
        if ($photo_ids) update_post_meta($post_id, 'photos', $photo_ids);
    }

    wp_send_json_success(['post_id' => $post_id]);
}