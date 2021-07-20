<?php
/**
 * Plugin Name: Basic Custom Post Type
 * Description:  WordPress allows developers to add custom post types to directly to a theme.  The problem with that is when the theme changes:  the custom posts go away!  A solution was needed.  This plugin is designed to offer a basic format for any custom post type that you might want to add.  By simply adding the shortcode on any page, the content and its formatting will remain constant with any theme.
 */

if(!defined('ABSPATH')){
    echo"What are you trying to do?  Hack me?  This plugin was created by a hacker.  Better luck elsewhere.  Free weve!";
   exit;
}

class Wptuts{
    public function __construct(){

        //Create custom post type
        add_action('init', array($this, 'create_custom_post_type'));

        //Add shortcode
        add_shortcode('ch-shortcode', array($this, 'load_shortcode'));

        //Add CSS
        add_action('wp_enqueue_scripts', [$this, 'load_css']);
    }
    

    //Setting arguments for custom post type
    public function create_custom_post_type(){
        $labels = array(
            'name'                  => _x( 'Tests', 'Post Type General Name', 'text_domain' ),
            'singular_name'         => _x( 'Test', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'             => __( 'Test CPT', 'text_domain' ),
            'name_admin_bar'        => __( 'Test CPT', 'text_domain' ),
            'archives'              => __( 'Item Archives', 'text_domain' ),
            'attributes'            => __( 'Item Attributes', 'text_domain' ),
            'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
            'all_items'             => __( 'All Items', 'text_domain' ),
            'add_new_item'          => __( 'Add New Item', 'text_domain' ),
            'add_new'               => __( 'Add New', 'text_domain' ),
            'new_item'              => __( 'New Item', 'text_domain' ),
            'edit_item'             => __( 'Edit Item', 'text_domain' ),
            'update_item'           => __( 'Update Item', 'text_domain' ),
            'view_item'             => __( 'View Item', 'text_domain' ),
            'view_items'            => __( 'View Items', 'text_domain' ),
            'search_items'          => __( 'Search Item', 'text_domain' ),
            'not_found'             => __( 'Not found', 'text_domain' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
            'featured_image'        => __( 'Featured Image', 'text_domain' ),
            'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
            'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
            'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
            'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
            'items_list'            => __( 'Items list', 'text_domain' ),
            'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
            'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
        );
        $args = array(
            'label'                 => __( 'Test', 'text_domain' ),
            'description'           => __( 'Post Type Description', 'text_domain' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail' ),
            'taxonomies'            => array( 'category', 'post_tag' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-buddicons-replies',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page'
        );

        //Initializing custom post type
        register_post_type('ch-test-cpt', $args);
    }

    //Creating shortcode functionality
    public function load_shortcode(){?>
        <?php $loop = new WP_Query(array(
            'post_type'   =>    'ch-test-cpt',
            'order_by'    =>    'post_id',
            'order'       =>    'ASC'
          ));?>

          <div class="snowcrash-plugin-wrapper">
    
            <?php while($loop->have_posts()) : $loop->the_post() ?>
                <div class="card">

                <?php the_post_thumbnail(); ?>

                <h2><?php the_title(); ?></h2>

                <span class="content"><?php the_content(); ?></span>

        </div>
          <?php endwhile; ?>
        </div>
        <?php
    }

    //Connect to custom CSS
    public function load_css(){
        wp_enqueue_style('ch_main_style', plugin_dir_url(__FILE__).'css/style.css');
    }
}
new Wptuts;