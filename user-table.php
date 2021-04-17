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

class userTable{

    public function __construct(){
        //some hooks may be
    }
    public function enqueue(){
        wp_enqueue_style('cj-bootstrap','https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
        wp_enqueue_script('cj-bootstrap-javascript','https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',array( 'jquery' ),'',true );
        wp_enqueue_style('cj-custom',plugins_url('resource/css/style-sheet.css',__FILE__));
        wp_enqueue_script('cj-custom',plugins_url('resource/js/javascript.js',__FILE__),array( 'jquery' ),'',true );       
    }
    public function get_users(){
        // create curl resource
        $ch = curl_init();
        // set url
        curl_setopt($ch, CURLOPT_URL, "https://jsonplaceholder.typicode.com/users");
        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string
        $output = curl_exec($ch);
        //var_dump($output);
        // close curl resource to free up system resources
        curl_close($ch);
        return json_decode($output);
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
    }
}

//Add a gobal var to access outside of init scope
Global $CJUserTable;

//Init
$CJUserTable = new userTable();
add_action('wp_enqueue_scripts',[$CJUserTable,'enqueue']);
add_filter('template_include',[$CJUserTable,'cj_custom_permalink']);

?>
