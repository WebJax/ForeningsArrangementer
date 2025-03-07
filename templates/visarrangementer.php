<?php
/* Template Name: Vis Arrangementer */

get_header();

$forening_navn = get_query_var('forening_navn');
$arrangementer = get_post_meta(get_the_ID(), 'fritid_arrangementer', true);
$baggrundsbillede = get_post_meta(get_the_ID(), 'fritid_baggrundsbillede', true);
?>

<div style="background-image: url('<?php echo esc_url($baggrundsbillede); ?>'); background-size: cover;">
    <h1><?php echo esc_html($forening_navn); ?> Arrangementer</h1>
    <div class="arrangementer-container">
        <?php if (!empty($arrangementer)) : ?>
            <?php foreach ($arrangementer as $arrangement) : ?>
                <div class="arrangement">
                    <h2><?php echo esc_html($arrangement['navn']); ?></h2>
                    <p><?php echo esc_html($arrangement['beskrivelse']); ?></p>
                    <p>Startdato: <?php echo esc_html($arrangement['startdato']); ?></p>
                    <p>Slutdato: <?php echo esc_html($arrangement['slutdato']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Ingen arrangementer fundet.</p>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
