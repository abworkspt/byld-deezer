<?php
global $post;
$pageid = $post->ID;

$success_image = get_field('success_image', $pageid);
$success_title = get_field('success_title', $pageid);
$success_text = get_field('success_text', $pageid);
?>

<div class="insc-overlay" data-control="INSCPHASE1">
    <div class="bg js-insc-close"></div>

    <div class="insc-modal" role="dialog" aria-modal="true" aria-labelledby="insc-title">

        <div class="insc-scroll">
            <svg class="insc-close js-insc-close" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M28 2.81879L16.8188 14L28 25.1812L25.1812 28L14 16.8188L2.81879 28L0 25.1812L11.1812 14L0 2.81879L2.81879 0L14 11.1812L25.1812 0L28 2.81879Z" fill="#11192E" style="fill:#11192E;fill:color(display-p3 0.0667 0.0980 0.1804);fill-opacity:1;" />
            </svg>


            <div class="insc-head">
                <div class="title" id="insc-title">PRÊT.E À T'INSCRIRE ?</div>
                <p class="blurb">Remplis les champs indiqués et envoie-nous ton formulaire d’inscription.</p>
            </div>

            <?php $ajax_url = admin_url('admin-ajax.php'); ?>
            <form action="<?php echo esc_url($ajax_url); ?>" method="post" enctype="multipart/form-data" class="insc-form" novalidate>
                <input type="hidden" name="action" value="abw_submit_participant">
                <input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce('abw_participant_nonce'); ?>">

                <div class="insc-grid">
                    <label>Nom *<input name="nome" required placeholder="Nom"></label>
                    <label>Prénom *<input name="apelido" placeholder="Prénom"></label>

                    <label>Email *<input type="email" name="email" required placeholder="moi@email.com"></label>
                    <label>Numéro de téléphone *<input name="telefone" inputmode="tel" placeholder="06 XX XX XX XX" required></label>

                    <label>Ton âge *<input type="date" name="nascimento" lang="fr" required></label>
                    <label>Ta ville *<input name="cidade" placeholder="ex. Marseille"></label>

                    <label>Nom de ton groupe *<input name="grupo" placeholder="Groupe"></label>
                    <label>Style musical *<input name="estilo" placeholder="ex. Rock"></label>

                    <label>Compte Instagram *<input name="instagram" placeholder="@Instagram"></label>
                    <label>Ton son disponible sur Deezer *<input type="url" name="deezer" placeholder="Lien Deezer"></label>
                </div>

                <div class="insc-upload-head">
                    <h2>Télécharge tes photos</h2>
                    <p>5 photos maximum</p>
                </div>

                <!-- Upload -->
                <div class="insc-upload">
                    <div class="zone" aria-hidden="true">

                        <svg class="ico" width="42" height="33" viewBox="0 0 42 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.708008 17.2844V32.1517H40.708V17.2844" stroke="black" style="stroke:black;stroke-opacity:1;" stroke-width="1.41593" />
                            <path d="M21.239 21.1782V1.00122" stroke="black" style="stroke:black;stroke-opacity:1;" stroke-width="1.41593" />
                            <path d="M12.708 9.50122L21.208 1.00122L29.708 9.50122" stroke="black" style="stroke:black;stroke-opacity:1;" stroke-width="1.41593" />
                        </svg>

                        <p><strong>Glisse</strong> tes photos ici ou <strong>Parcours</strong> tes fichiers.</p>
                        <span class="hint">Extensions : jpg, png. Poids maximal du fichier : 10Mo</span>
                    </div>
                    <input class="upload-file" type="file" name="fotos[]" accept=".jpg,.jpeg,.png" multiple aria-label="Télécharge tes photos (max 5)">
                    <!-- Se quiseres listar ficheiros adiciona .file itens aqui -->
                </div>

                <!-- Footer: consentimento + botão -->
                <div class="insc-footer">
                    <div class="submit-container">
                        <button class="button invert" type="submit"><span>JE VALIDE MON INSCRIPTION</span></button>
                        <img class="loader" src="<?php echo get_bloginfo('template_url'); ?>/images/loader.gif" />
                    </div>

                    <label class="consent">
                        <input type="checkbox" name="consent" required>
                        <p>J’accepte le <a href="#">règlement</a> et <a href="#">conditions</a> du jeu concours.</p>
                    </label>
                </div>
            </form>

            <?php if (isset($_GET['insc'])): ?>
                <div class="insc-msg <?php echo $_GET['insc'] === 'ok' ? 'ok' : 'erro'; ?>">
                    <?php echo $_GET['insc'] === 'ok' ? 'Inscription envoyée avec succès !' : esc_html($_GET['msg'] ?? 'Erreur lors de l’envoi.'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="success-screen">
        <svg class="insc-close js-insc-close" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M28 2.81879L16.8188 14L28 25.1812L25.1812 28L14 16.8188L2.81879 28L0 25.1812L11.1812 14L0 2.81879L2.81879 0L14 11.1812L25.1812 0L28 2.81879Z" fill="#11192E" style="fill:#11192E;fill:color(display-p3 0.0667 0.0980 0.1804);fill-opacity:1;" />
        </svg>

        <img src="<?php echo $success_image['url']; ?>" alt="" />
        <div class="info">
            <h2><?php echo $success_title; ?></h2>
            <div class="text"><?php echo $success_text; ?></div>
        </div>
    </div>
</div>