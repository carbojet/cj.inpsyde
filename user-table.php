<?php
/**
 * Plugin Name:       User Table
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Interview test for a german company named inpsyde
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Sunil Kumar Mutaka
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */
defined( 'ABSPATH' ) or die( 'Hay, What are you doing here ? You silly humen' );
if(!class_exists('cjUserTable')){
    class cjUserTable{

        public function __construct(){
            //some hooks may be
            var $baseAPIUrl = 'https://jsonplaceholder.typicode.com';
            var $output = null;
            var $ajaxUrl = admin_url('admin-ajax.php');
        }
        public function enqueue(){
            wp_enqueue_style('cj-bootstrap','https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
            wp_enqueue_script('cj-bootstrap-javascript','https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',array( 'jquery' ),'',true );
            wp_enqueue_style('cj-custom-style',plugins_url('resource/css/style-sheet.css',__FILE__));
            wp_enqueue_script('cj-custom-script',plugins_url('resource/js/javascript.js',__FILE__),array( 'jquery' ),'',true );
            wp_localize_script('cj-custom-script','cjcs',array( 'ajaxUrl'=>admin_url('admin-ajax.php') ) );      
        }
        private function curlcall($url){

            // create curl resource
            $ch = curl_init();
            // set url
            curl_setopt($ch, CURLOPT_URL, $this->baseAPIUrl.$url);
            //return the transfer as a string
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // $output contains the output string
            $output = curl_exec($ch);
            //var_dump($output);
            // close curl resource to free up system resources
            curl_close($ch);
            $this->output = json_decode($output);
        }
        public function get_users(){
            $this->curlcall('/users');
            return $this->output;
        }
        public function cj_custom_permalink($template){
            if(is_404()){
                global $wp;
                if($wp->request=='cj-custom-userlist'){
                    return plugin_dir_path(__FILE__).'templates/404.php';
                }else{
                    return $template;
                }
            }
            return $template;
        }

        public function cj_get_user_details(){
            $user_id  = $_POST['user_id'];
            $this->curlcall("/users"."/".$user_id);
            return $this->output;
        }
    }

    //Add a gobal var to access outside of init scope
    Global $cjUserTable;

    //Init
    $cjUserTable = new cjUserTable();
    add_action('wp_enqueue_scripts',[$cjUserTable,'enqueue']);
    add_filter('template_include',[$cjUserTable,'cj_custom_permalink']);

    add_action('wp_ajax_nopriv_get_user_details', [$cjUserTable,'cj_get_user_details']);
    add_action('wp_ajax_get_user_details',[$cjUserTable,'cj_get_user_details']);
}
?>
