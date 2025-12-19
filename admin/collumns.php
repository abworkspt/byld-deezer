<?php
/**
 * PARTICIPANT – Coluna "Votos" ordenável (tempo real)
 */

/* --------------------------------------------------
 * 1. Adicionar coluna "Votos" antes da data
 * -------------------------------------------------- */
add_filter('manage_participant_posts_columns', function ($columns) {

    $new = [];

    foreach ($columns as $key => $label) {
        if ($key === 'date') {
            $new['votes_count'] = 'Votes';
        }
        $new[$key] = $label;
    }

    return $new;
});


/* --------------------------------------------------
 * 2. Preencher a coluna "Votos"
 * -------------------------------------------------- */
add_action('manage_participant_posts_custom_column', function ($column_name, $post_id) {

    if ($column_name !== 'votes_count') return;

    global $wpdb;

    $id = (string) $post_id;
    $like_serialized = '%"' . $wpdb->esc_like($id) . '"%';

    $count = (int) $wpdb->get_var($wpdb->prepare("
        SELECT COUNT(*)
        FROM {$wpdb->posts} p
        INNER JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID
        WHERE p.post_type = 'vote'
          AND p.post_status = 'publish'
          AND pm.meta_key = 'participant_id'
          AND (pm.meta_value = %s OR pm.meta_value LIKE %s)
    ", $id, $like_serialized));

    echo $count;

}, 10, 2);


/* --------------------------------------------------
 * 3. Tornar a coluna ordenável
 * -------------------------------------------------- */
add_filter('manage_edit-participant_sortable_columns', function ($columns) {
    $columns['votes_count'] = 'votes_count';
    return $columns;
});


/* --------------------------------------------------
 * 4. Detetar ordenação por votos
 * -------------------------------------------------- */
add_action('pre_get_posts', function ($query) {

    if (
        ! is_admin() ||
        ! $query->is_main_query() ||
        $query->get('post_type') !== 'participant'
    ) {
        return;
    }

    if ($query->get('orderby') === 'votes_count') {
        // flag interna para usar no filtro posts_clauses
        $query->set('votes_ordering', true);
    }
});


/* --------------------------------------------------
 * 5. Aplicar JOIN + ORDER BY (SEM closures na query)
 * -------------------------------------------------- */
add_filter('posts_clauses', function ($clauses, $query) {

    if (
        ! is_admin() ||
        ! $query->is_main_query() ||
        ! $query->get('votes_ordering')
    ) {
        return $clauses;
    }

    global $wpdb;

    $order = strtoupper($query->get('order')) === 'ASC' ? 'ASC' : 'DESC';

    $clauses['join'] .= "
        LEFT JOIN (
            SELECT
                pm.meta_value AS participant_id,
                COUNT(*) AS votes_count
            FROM {$wpdb->posts} p
            INNER JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID
            WHERE p.post_type = 'vote'
              AND p.post_status = 'publish'
              AND pm.meta_key = 'participant_id'
            GROUP BY pm.meta_value
        ) votes ON votes.participant_id = {$wpdb->posts}.ID
    ";

    $clauses['orderby'] = "COALESCE(votes.votes_count, 0) $order";

    return $clauses;

}, 10, 2);