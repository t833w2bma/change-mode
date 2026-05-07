<?php
/**
 * Plugin Name: change mode permission ver1.0.0
 * Description: Wordpressに書き込み権限を与えたり除去したり
 * * Author: Izumikawa
 */


  final class ChangeModeMain {
    private static $wp_dir;
    protected static $mdir;


    function __construct(){
      @session_start();
      self::$mdir =  dirname( plugin_basename( __FILE__ ) ) ;

      // 管理メニューにフックを登録
      add_action('admin_menu',array( $this, 'add_quote_setting' ) );

      add_action('admin_print_styles',  function () {
        echo '<style>.pl-1{ padding-left: 1em;} .pl-1 h4{font-size:1.15em;font-weight:600;margin-bottom:.5em;}article.pl-1 {
          padding-bottom: 2em;}pre.ta-minal {background: #333;width: 800px;padding: 1em;font-size: 1.2em;color: #0f0;font-family: "courier NEW" ,consolas;}
        </style>';
      } ); 

       
    }










    /*
      メニューを追加する
    */

    public function add_quote_setting(){
      $my_plugin_slug = self::$mdir ; 
    
      // トップレベルにオリジナルのメニューを追加（購読者相当 read editor manage_options
      add_menu_page('CangeMode', 'CangeMode', 'moderate_comments',
          $my_plugin_slug,
          array($this,'ds_form_view'),
          plugins_url('/images/icon-admin.png', __FILE__),
          11
      );
    }

    public function ds_form_view(){

      if( !empty( $_POST['wps']) ){ 
        //wp ディレクトリの権限を変える
        if( $_POST['wps'] == 'Wordpress' ) {
          $this->wpProtect('775','664'); //与える
          
        }elseif($_POST['wps'] == 'Other'){
          $this->wpProtect('555','444'); //与えない
        }
        
      }elseif(!empty( $_POST['thp'])){
        //テーマ､プラグイン ディレクトリの権限を変える
        if( $_POST['thp'] == 'Wordpress' ) {
          $this->modProtect('775','664'); //与える
          
        }elseif($_POST['thp'] == 'Other'){
          $this->modProtect('555','444'); //与えない
        }

      }

      
      if (empty($_SESSION['cmdx']['results'])) {
        $results = shell_exec('ls -la ' .ABSPATH .'wp-content');
        $_SESSION['cmdx']['results'] =  "<pre class='ta-minal'>$results</pre>";
      }
        
      include 'ds-form-view.php';
      
    }

    

    
    /* WPに書き込み権限を与えない570与える770*/
    protected function wpProtect($mod1 ,$mod2){
      $cmd = "find " .ABSPATH. " -type d -exec chmod $mod1 {} + \n";
      $cmd .= "find " .ABSPATH. " -type f -exec chmod $mod2 {} + " ;
      shell_exec($cmd) ;
      $results = shell_exec('ls -la ' .ABSPATH);
      $_SESSION['cmdx']['results'] =  "<pre class='ta-minal'>$results</pre>";
    }
    
    protected function modProtect($mod1, $mod2){
      $cmd = "find " .ABSPATH. "/wp-content -type d -exec chmod $mod1 {} + \n";
      $cmd .= "find " .ABSPATH. "/wp-content -type f -exec chmod $mod2 {} + ";
      // var_dump($cmd);
      // find /data/am.ultimai/wp/wp-content -type d -exec chmod 555 {} +" 
      shell_exec($cmd);
      $results = shell_exec('ls -la ' .ABSPATH.'wp-content');
      $_SESSION['cmdx']['results'] =  "<pre class='ta-minal'>$results</pre>";
    }
    

  }
  
  new ChangeModeMain;