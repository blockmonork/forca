<?php
class Forca {

      var $total_letras = 0;
      var $palavra = '';
      var $alvo_txt = 'easy.txt';

      /*** publicos ***/
      function set_alvo_txt($v)
      {
               $this->alvo_txt = $v;
      }
      function generate()
      {
               $this->_get_txt();
      }
      function show_letras()
      {
               $retorno = '';
               for ( $i = 0; $i < $this->total_letras; $i++ ){
                   $retorno .= '<div class="letra" id="letra'.$i.'"></div>';
               }
               return $retorno;
      }

      /*** PRIVADOS ***/
      function _get_txt()
      {
               $temp_txt = @file_get_contents($this->alvo_txt);
               if ( !$temp_txt ) { echo 'Nao foi possivel abrir arquivo de texto ('.$this->alvo_txt.')!'; exit; }
               $this->palavra = $this->_get_palavra($temp_txt);
      }
      function _get_palavra($temp_txt)
      {
               $r = '';
               $temp = $this->_limpa_texto($temp_txt);
               $E = explode(' ', $temp);
               $total = count($E)-1;
               $rand = rand(0, $total);
               $P = $this->_limpa_texto($E[$rand]);
               $this->total_letras = strlen($P);
               if ( $this->total_letras < 3 or $P == '' ){
                  $r = $this->_get_palavra($temp);
               }else{
                     return strtoupper($P);
               }
      }
      function _limpa_texto($txt)
      {
               return strip_tags(
               str_replace('\r\n', ' ',
               str_replace('.', '',
               str_replace('...', '',
               str_replace('?', '',
               str_replace('!', '',
               str_replace('"', '',
               str_replace("'", "",
               trim($txt) ) ) ) ) ) ) ) );
      }
}
?>
