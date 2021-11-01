var game = {
	is_running:false,
	is_debug:false,
	jogada:0,
	pontos:0,
	pontos_now:0,
	total_letras:0,
	palavra:'',
	imagem:0,
	grava_status:function(msg){
		var soma = ( msg == 'win' ) ? 1 : 0;
		var pts = this._get('forcaPontos') + soma;
		var jgs = this._get('forcaJogadas') +1;
		if ( jgs == 1 ) jgs = 2;
		if ( msg == 'win' ) ws.set('forcaPontos', pts);
		ws.set('forcaJogadas', jgs);
		$('#Pontos').html(pts);
	},
	end_game:function(msg){
		this.is_running = false;
		this.grava_status(msg);
		var txt = ( msg == 'win' ) ? 'Voce acertou!' : 'Voce perdeu!';
		$('#letras').html('<h3>'+txt+' Palavra: "'+this.palavra+'"</h3>');
		$('#inputs').html('<a href="./">Jogar de novo</a>');
	},
	checar:function(){
		ok = 0;
		var txt = '';
		var inputed = $('#inputTexto').val() || false;
		if ( !inputed ){
			alert('digite uma letra e tente novamente');
			return;
		}
		for ( j = 0; j < this.palavra.length; j++ ){
			letra = this.palavra.charAt(j);
			letra_span = $('#letra'+j).html();
			txt += 'j('+j+'),  input('+inputed+'), palavra.letra('+letra+'), letra_span('+letra_span+')<br>';
			if ( inputed == letra && letra_span == '' ){
				$('#letra'+j).html(inputed);
				ok++;
				this.pontos_now++;
			}
		}
		if ( this.is_debug ) {
			$('#debug').html(txt);
		}
		if ( ok == 0 ){
			this.imagem++;
			$('#imgContainer').html('<img src="' +this.imagem+ '.gif" />');
		}else{
			if ( this.pontos_now == this.total_letras ){
				this.end_game('win');
			}
		}
		if ( this.imagem == 10 ) {
			this.end_game('loose');				
		}
		$('#inputTexto').val('').focus();
	},
	_get:function(item){
		var x = ws.get(item) || 0;
		return ( x != 0 ) ? parseInt(x) : 0;
	},
	init:function(){
		this.is_running = true;
		this.is_debug = _is_debug;
		this.jogada = this._get('forcaJogadas');
		if ( this.jogada == 0 ) { this.jogada = 1; }
		this.pontos = this._get('forcaPontos');
		this.total_letras = _total;
		this.palavra = _palavra;
		$('#Jogo').html(this.jogada);
		$('#Pontos').html(this.pontos);
		if ( this.is_debug ){
			alert('game.init() - palavra('+this.palavra+'), letras('+this.total_letras+')');
		}
	},
};
$(document).ready(function(){
	$('#site').gradient({
		direction:'45deg',
		colors: 'white, #efefef'
	});
	
	$('input').keyup(function(){
		x = $(this).val();
		$(this).val(x.toUpperCase());
	});
	game.init();
	$('#Checar').click(function(){
		if ( game.is_running ){
			game.checar();
		}
	});
	$('#inputTexto').bind('keyup', function(){
		if ( $(this).val() != '' ){
			$('#Checar').focus();
		}
	});
	$('#inputTexto').focus();
});

