
<style>
.pl-1{ padding-left: 1em;} 
.pl-1 h4{font-size:1.15em;font-weight:600;margin-bottom:.5em;color: #3574b5;}
article.pl-1 {padding-bottom: 2em;padding: .2em 0 1em 1em !important; background: #fefefe;border-bottom: solid 1px #ccc;}
pre.ta-minal {background: #333;width: 100%;padding: 1em;font-size: 1.2em;color: #0f0;font-family: "courier NEW" ,consolas;box-sizing: border-box;}
.pl-1 label{margin: 2em;}
.w-95{width:95%}
.cmdx h3{background: #fff; line-height: 2em; border-bottom: 1px solid;  padding-left: .5em;}
</style>



<div class="container">
  <div class="row cmdx">
    <section class="w-95 col-8">
        <h3>今風------の書き込み権限</h3>
<?php

if (isset($_SESSION['cmdx']['results'])) echo $_SESSION['cmdx']['results'] ;
$_SESSION['cmdx'] = null;

?>
      <form id="wpdir" action="" method="post">
        <article class="pl-1">
          <h4><strong>ディレクトリ</strong> <span>Wordpress</span></h4>  
          <p  class="pl-1">
            <strong>書き込み権限</strong>
<?php
  $wpwritable = is_writable( ABSPATH) ;
  $checked = array_fill(0,2,'');
  if( $wpwritable ){
    $checked[0] = 'checked';
  }else{
    $checked[1] = 'checked';
  }
  $wpckindex = 0;
  ?>
            <label><input type="radio" name="wps" value="Wordpress" <?=$checked[$wpckindex]?>>許可する</label>
            <label><input type="radio" name="wps" value="Other" <?=$checked[++$wpckindex]?>>禁止する</label>
          </p>
        </article>
      </form>





      <form id="contdir" action="" method="post">
        <article class="pl-1">
          <h4><strong>ディレクトリ</strong> <span>uploads & theme & plugin</spa></h4>  
          <p class="pl-1">
            <strong>書き込み権限</strong>
  <?php
    $writable = is_writable( ABSPATH."/wp-content") ;
    $checked = array_fill(0,2,'');
    if( $writable ){
      $checked[0] = 'checked';
    }else{
      $checked[1] = 'checked';
    }
    $ckindex = 0;
  ?>
            <label><input type="radio" name="thp" value="Wordpress" <?=$checked[$ckindex]?>>許可する</label>
            <label><input type="radio" name="thp" value="Other" <?=$checked[++$ckindex]?>>禁止する</label>
          </p>
        </article>
      </form>

    </section>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    jQuery(function ($) {
      
      $('[name="thp"]').change( function(){
        $('#contdir').submit();
      });
      
      $('[name="wps"]').change( function(){
        $('#wpdir').submit();
      });



    });
  });
</script>