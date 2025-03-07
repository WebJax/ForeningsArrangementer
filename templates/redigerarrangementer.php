<?php
/* Template Name: Rediger Arrangementer */

get_header();

$post_id = get_the_ID();
$arrangementer = get_post_meta($post_id, 'fritid_arrangementer', true);
$baggrundsbillede = get_post_meta($post_id, 'fritid_baggrundsbillede', true);
?>

<div style="background-image: url('<?php echo esc_url($baggrundsbillede); ?>'); background-size: cover;">
    <h2>Rediger Arrangementer</h2>
    <div id="arrangementer-liste">
        <?php if (!empty($arrangementer)) : ?>
            <?php foreach ($arrangementer as $arrangement) : ?>
                <div class="arrangement">
                    <h3><?php echo esc_html($arrangement['navn']); ?></h3>
                    <p><?php echo esc_html($arrangement['beskrivelse']); ?></p>
                    <p>Startdato: <?php echo esc_html($arrangement['startdato']); ?></p>
                    <p>Slutdato: <?php echo esc_html($arrangement['slutdato']); ?></p>
                    <button class="slet-arrangement" data-id="<?php echo esc_attr($arrangement['id']); ?>">Slet</button>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Ingen arrangementer fundet.</p>
        <?php endif; ?>
    </div>
    <form id="tilfoj-arrangement-form">
        <input type="text" name="navn" placeholder="Navn" required>
        <textarea name="beskrivelse" placeholder="Beskrivelse" required></textarea>
        <input type="date" name="startdato" required>
        <input type="date" name="slutdato" required>
        <button type="submit">Tilføj Arrangement</button>
    </form>
    <form id="opdater-baggrundsbillede-form" enctype="multipart/form-data">
        <input type="file" name="baggrundsbillede" accept="image/*" required>
        <button type="submit">Opdater Baggrundsbillede</button>
    </form>
</div>

<?php get_footer(); ?>
