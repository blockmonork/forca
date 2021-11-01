<?php
function Site_debug(){ return ( strstr(basename($_SERVER['HTTP_HOST']), 'localhost') ) ? true : false; }
$root_dir = '../../z_js_loader_fafm/';
$x = '';
if ( isset($_GET['fase']) ){
   $file = trim($_GET['fase']);
   $file = ( $file == 1 ) ? 'easy.txt' : 'hard.txt';
   if ( !file_exists($file) ){
      $file = 'easy.txt';
   }
}else{
      $file = 'easy.txt';
}
if ( $file == 'easy.txt' ){
   $switch_fase = '<a href="?fase=2">hard</a>';
   $reset = '<a href="?fase=1">reset</a>';
}else{
   $switch_fase = '<a href="?fase=1">hard</a>';
   $reset = '<a href="?fase=2">reset</a>';
}
include ('forca.php');
$_forca = new Forca();
$_forca->set_alvo_txt($file);
$_forca->generate();
$js_ini = '';
$game_debug = false;
$js_debug = ( $game_debug ) ? 'true' : 'false';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>BomBrain: Jogo da Forca</title>
</head>
<body>
<div id="site">
     <div class="box rounded5 pad5 b_silver text_center shadow" id="conteudo">
          <h1>Forca</h1>

          <div id="imgContainer"></div>
          <hr>
          <div id="gameMenu">
               Jogo:<span id="Jogo"></span>
               (<?php echo strtoupper(str_replace('.txt', '', $file)); ?>)
               Pontos:<span id="Pontos"></span>
               switch to: <?php echo $switch_fase . ' | ' . $reset; ?>
          </div>
          
          <div id="letras">
               <small>(<?php echo $_forca->total_letras;?>letras)</small>
               <?php echo $_forca->show_letras();?>
          </div>
          <div id="inputs"><input type="text" id="inputTexto" maxlength="1">&nbsp;<button id="Checar">checar</button></div>

     </div>
     <?php if ( $game_debug ) : ?>
     <div id="debug"><?php echo $_forca->alvo_txt;?></div>
     <?php endif; ?>
     
     <div class="contador">www.BomBrain.com.br &copy; <?php echo $x; ?></div>
</div>
<script> var _total = <?php echo $_forca->total_letras; ?>; var _palavra = "<?php echo $_forca->palavra; ?>"; var _is_debug = <?php echo $js_debug; ?>; </script>

<script src="<?php echo $root_dir;?>loader.js"></script>
<script>
_fLoad('default', '<?php echo $root_dir;?>'); _fLoadOut(['css.css', 'js.js']);
</script>
<?php echo $js_ini; ?>
</body>
</html>

