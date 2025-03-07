<?php

class ForeningArrangementer {
    private $post_type = 'foreningsside';

    public function __construct() {
        add_action('init', array($this, 'register_custom_fields'));
        add_action('init', array($this, 'register_rewrite_rules'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('template_redirect', array($this, 'handle_custom_endpoint'));
        add_shortcode('vis_arrangementer', array($this, 'vis_arrangementer_shortcode'));
        add_action('wp_ajax_gem_arrangement', array($this, 'gem_arrangement'));
        add_action('wp_ajax_slet_arrangement', array($this, 'slet_arrangement'));
        add_action('wp_ajax_opdater_baggrundsbillede', array($this, 'opdater_baggrundsbillede'));
    }

    public function register_custom_fields() {
        register_post_meta($this->post_type, 'fritid_arrangementer', array(
            'show_in_rest' => true,
            'single' => true,
            'type' => 'array',
        ));

        register_post_meta($this->post_type, 'fritid_baggrundsbillede', array(
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ));
    }

    public function register_rewrite_rules() {
        add_rewrite_rule(
            '^forening/([^/]+)-screen/?',
            'index.php?pagename=foreningsside&forening_navn=$matches[1]',
            'top'
        );
    }

    public function handle_custom_endpoint() {
        global $wp_query;

        if (isset($wp_query->query_vars['pagename']) && $wp_query->query_vars['pagename'] === 'foreningsside') {
            $forening_navn = get_query_var('forening_navn');
            $this->vis_forenings_arrangementer($forening_navn);
            exit;
        }
    }

    public function vis_forenings_arrangementer($forening_navn) {
        $args = array(
            'post_type' => $this->post_type,
            'meta_query' => array(
                array(
                    'key' => 'fritid_payed_name',
                    'value' => $forening_navn,
                    'compare' => '='
                )
            )
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            $query->the_post();
            get_template_part('arrangementer-template');
        } else {
            echo 'Forening ikke fundet.';
        }

        wp_reset_postdata();
    }

    public function enqueue_scripts() {
        wp_enqueue_script('forening-arrangementer-js', plugin_dir_url(__FILE__) . 'forening-arrangementer.js', array('jquery'), null, true);
        wp_localize_script('forening-arrangementer-js', 'forening_arrangementer_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('forening_arrangementer_nonce'),
        ));
    }

    public function vis_arrangementer_shortcode() {
        ob_start();
        get_template_part('rediger-arrangementer-template');
        return ob_get_clean();
    }

    public function gem_arrangement() {
        check_ajax_referer('forening_arrangementer_nonce', 'nonce');

        $post_id = intval($_POST['post_id']);
        $arrangementer = get_post_meta($post_id, 'fritid_arrangementer', true);
        $nyt_arrangement = array(
            'id' => uniqid(),
            'navn' => sanitize_text_field($_POST['navn']),
            'beskrivelse' => sanitize_textarea_field($_POST['beskrivelse']),
            'startdato' => sanitize_text_field($_POST['startdato']),
            'slutdato' => sanitize_text_field($_POST['slutdato']),
        );
        $arrangementer[] = $nyt_arrangement;
        update_post_meta($post_id, 'fritid_arrangementer', $arrangementer);

        wp_send_json_success('Arrangement tilføjet.');
    }

    public function slet_arrangement() {
        check_ajax_referer('forening_arrangementer_nonce', 'nonce');

        $post_id = intval($_POST['post_id']);
        $arrangement_id = sanitize_text_field($_POST['arrangement_id']);
        $arrangementer = get_post_meta($post_id, 'fritid_arrangementer', true);

        foreach ($arrangementer as $key => $arrangement) {
            if ($arrangement['id'] === $arrangement_id) {
                unset($arrangementer[$key]);
                break;
            }
        }

        update_post_meta($post_id, 'fritid_arrangementer', $arrangementer);

        wp_send_json_success('Arrangement slettet.');
    }

    public function opdater_baggrundsbillede() {
        check_ajax_referer('forening_arrangementer_nonce', 'nonce');

        $post_id = intval($_POST['post_id']);

        if (isset($_FILES['baggrundsbillede']) && !empty($_FILES['baggrundsbillede']['name'])) {
            $upload = wp_handle_upload($_FILES['baggrundsbillede'], array('test_form' => false));
            if (isset($upload['url'])) {
                update_post_meta($post_id, 'fritid_baggrundsbillede', $upload['url']);
                wp_send_json_success('Baggrundsbillede opdateret.');
            } else {
                wp_send_json_error('Fejl ved upload af billede.');
            }
        } else {
            wp_send_json_error('Ingen fil valgt.');
        }
    }
}

new ForeningArrangementer();
?>
