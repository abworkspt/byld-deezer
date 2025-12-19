<?php
if (have_posts()) :
    while (have_posts()) : the_post();
        $pid = get_the_ID();
    endwhile;
endif;
?>

<section id="popup-vote">
    <div class="bg"></div>
    <div class="popup">
        <div class="inside show">


            <svg class="close" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_2422_688)">
                    <path d="M28 2.81879L16.8188 14L28 25.1812L25.1812 28L14 16.8188L2.81879 28L0 25.1812L11.1812 14L0 2.81879L2.81879 0L14 11.1812L25.1812 0L28 2.81879Z" fill="#11192E" style="fill:#11192E;fill:color(display-p3 0.0667 0.0980 0.1804);fill-opacity:1;" />
                </g>
                <defs>
                    <clipPath id="clip0_2422_688">
                        <rect width="28" height="28" fill="white" style="fill:white;fill-opacity:1;" />
                    </clipPath>
                </defs>
            </svg>

            <div class="top">
                <h2>Encore un clic et ton vote compte</h2>
                <p>Entre ton adresse email pour finaliser ton vote pour <?php echo get_the_title($pid); ?></p>
            </div>


            <div class="field">
                <p>Email</p>
                <form id="vote-form">
                    <input type="text" class="email-input" name="email" placeholder="Email" />
                    <input type="hidden" class="pid" name="pid" value="<?php echo esc_attr($pid); ?>" />
                    <input type="hidden" name="action" value="abw_submit_vote">
                    <?php wp_nonce_field('abw_vote', 'security'); ?>
                </form>

                <div class="error"></div>
            </div>


            <div class="row">
                <div class="checkfield">
                    <div class="check js-reg">
                        <svg width="14" height="10" viewBox="0 0 14 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.353516 5.35358L3.64641 8.64647C4.03693 9.03699 4.6701 9.03699 5.06062 8.64647L13.3535 0.353577" stroke="#11192E" style="stroke:#11192E;stroke:color(display-p3 0.0667 0.0980 0.1804);stroke-opacity:1;" />
                        </svg>

                    </div>
                    <p>J'accepte le <a href="<?php echo home_url(); ?>/reglement/">règlement</a> du jeu concours et certifie avoir plus de 18 ans.</p>
                </div>

                <!--<div class="checkfield">
                    <div class="check js-terms">
                        <svg width="14" height="10" viewBox="0 0 14 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.353516 5.35358L3.64641 8.64647C4.03693 9.03699 4.6701 9.03699 5.06062 8.64647L13.3535 0.353577" stroke="#11192E" style="stroke:#11192E;stroke:color(display-p3 0.0667 0.0980 0.1804);stroke-opacity:1;" />
                        </svg>
                    </div>
                    <p>J'accepte de recevoir de la part de Volkswagen Group France et de ses partenaires**, des offres commerciales y compris des offres personnalisées en fonction de mes données d'achat concernant les produits et services qu'ils proposent</p>

                </div>-->

            </div>
            <div class="row bts">
                <a href="#" class="button invert sendVote">C'est parti !</a>
                <a href="#" class="button js-close">Retour page Artiste</a>
            </div>

        </div>
        <div class="success">
            <svg class="close" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_2422_688)">
                    <path d="M28 2.81879L16.8188 14L28 25.1812L25.1812 28L14 16.8188L2.81879 28L0 25.1812L11.1812 14L0 2.81879L2.81879 0L14 11.1812L25.1812 0L28 2.81879Z" fill="#11192E" style="fill:#11192E;fill:color(display-p3 0.0667 0.0980 0.1804);fill-opacity:1;" />
                </g>
                <defs>
                    <clipPath id="clip0_2422_688">
                        <rect width="28" height="28" fill="white" style="fill:white;fill-opacity:1;" />
                    </clipPath>
                </defs>
            </svg>

            <div class="center">
                <h2>Merci pour<br />ton vote !</h2>
                <p>Nous contacterons les vainqueurs des dotations par mail.</p>
            </div>
            <a href="#" class="back button invert js-close">Retour</a>
        </div>
    </div>
</section>