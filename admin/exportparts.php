<?php

/**
 * Botão "Export CSV" na listagem do CPT "participant"
 * + exportação dos campos ACF em francês
 * + data de inscrição
 * usando admin-post.php (download direto).
 */


/**
 * 1) Adiciona o botão "Export CSV" ao lado do "Add New Participant"
 */
add_action('admin_head-edit.php', function () {
    global $typenow;

    if ($typenow !== 'participant') {
        return;
    }

    // URL simples para admin-post.php sem nonce
    $export_url = admin_url('admin-post.php?action=export_participants');
?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var addNewBtn = document.querySelector('.page-title-action');
            if (!addNewBtn) return;

            var exportBtn = document.createElement('a');
            exportBtn.className = 'page-title-action';
            exportBtn.href = '<?php echo esc_js($export_url); ?>';
            exportBtn.textContent = 'Export CSV';

            // insere imediatamente a seguir ao botão "Add New Participant"
            addNewBtn.insertAdjacentElement('afterend', exportBtn);
        });
    </script>
<?php
});


/**
 * 2) Handler do download de CSV
 *    (chamado por admin-post.php?action=export_participants)
 */
add_action('admin_post_export_participants', function () {

    // Garante que só admins (ou quem tiver manage_options) exportam
    if (!current_user_can('manage_options')) {
        wp_die('Sem permissão para exportar.');
    }

    // Nome do ficheiro
    $filename = 'participants-' . date('Y-m-d') . '.csv';

    // Headers para download direto
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename=' . $filename);
    header('Pragma: no-cache');
    header('Expires: 0');

    // BOM UTF-8 (acentos ok em Google Sheets, etc.)
    echo "\xEF\xBB\xBF";

    $out = fopen('php://output', 'w');

    // Cabeçalhos EXACTAMENTE como pediste
    fputcsv($out, [
        'DATE',
        'NOM',
        'PRÉNOM',
        'EMAIL',
        'TÉLÉPHONE',
        'ÂGE',
        'CODE POSTAL',
        'NOM D\'ARTISTE',
        'STYLE MUSICAL',
        'COMPTE INSTAGRAM',
        'DEEZER LINK',
        'DESCRIPTION',
    ]);

    // Query a todos os participants
    $q = new WP_Query([
        'post_type'      => 'participant',
        'post_status'    => 'any',
        'posts_per_page' => -1,
    ]);

    if ($q->have_posts()) {
        while ($q->have_posts()) {
            $q->the_post();

            $post_id = get_the_ID();

            $registration_date = get_the_date('Y-m-d H:i:s', $post_id);

            $last_name          = get_field('last_name', $post_id);
            $first_name         = get_field('first_name', $post_id);
            $email              = get_field('email', $post_id);
            $contact            = get_field('contact', $post_id);
            $age                = get_field('age', $post_id);
            $city               = get_field('city', $post_id);
            $group_name         = get_field('group_name', $post_id);
            $musical_style      = get_field('musical_style', $post_id);
            $instagram_account  = get_field('instagram_account', $post_id);
            $deezer_link        = get_field('deezer_link', $post_id);
            $description_groupe_raw = get_field('description_groupe', $post_id);
            $description_groupe     = wp_strip_all_tags($description_groupe_raw, true); // sem <p>, <br>, etc.


            fputcsv($out, [
                $registration_date,
                $last_name,
                $first_name,
                $email,
                $contact,
                $age,
                $city,
                $group_name,
                $musical_style,
                $instagram_account,
                $deezer_link,
                $description_groupe,
            ]);
        }
        wp_reset_postdata();
    }

    fclose($out);
    exit;
});
