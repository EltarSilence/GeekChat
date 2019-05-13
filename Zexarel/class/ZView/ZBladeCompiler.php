<?php
class ZBladeCompiler{

	private static $search = [
		'/\{+\{+\{([a-zA-Z0-9àèéìòù\s-_():=>;\,\.$\"\'\[\]]*(\n)?)\}+\}+\}/',
		'/\{+\{([a-zA-Z0-9àèéìòù\s-_():>;\.$"\'\[\]]*(\n)?)\}+\}/',
		'/\{+\-+\-([a-zA-Z0-9àèéìòù\s-_():>;\.$"\'\[\]]*(\n)?)\-+\-+\}/',
		'/\@if\(([a-zA-Z0-9*$\s=>\.<()+*\/%\-\"\'\[\]]*)\)/',
		'/\@elseif\(([a-zA-Z0-9*$\s=>\.<()+*\/%\-"\'\[\]]*)\)/',
		'/\@foreach\(([a-zA-Z0-9*$\s=>\.<()+*\/%\-"\'\[\]]*)\)/',
		'/\@for\(([a-zA-Z0-9*$\s=>\.<()+*\/%\-"\'\[\]]*)\)/',
		'/\@while\(([a-zA-Z0-9*$\s=>\.<()+*\/%\-"\'\[\]]*)\)/',
		'/\@enddowhile\(([a-zA-Z0-9*$\s=>\.<()+*\/%\-"\'\[\]]*)\)/',
		'/\@dowhile/',
		'/\@else/',
		'/\@endif/',
		'/\@endfor/',
		'/\@endoforeach/',
		'/\@endwhile/'
	];

	private static $replace = [
		'<?php $1; ?>',
		'<?php echo $1; ?>',
		'<?php /* $1 */ ?>',
		'<?php if($1){ ?>',
		'<?php }elseif($1){ ?>',
		'<?php foreach($1){ ?>',
		'<?php for($1){ ?>',
		'<?php while($1){ ?>',
		'<?php }while($1); ?>',
		'<?php do{ ?>',
		'<?php }else{ ?>',
		'<?php } ?>',
		'<?php } ?>',
		'<?php } ?>',
		'<?php } ?>'
	];

	public static function compile($str, $data = null){
		for($i = 0; $i < sizeof(static::$search); $i++){
			$str = preg_replace(static::$search[$i], static::$replace[$i], $str);
		}
		ob_start();
		if(sizeof($data) > 0){
			foreach($data as $k => $v){
				${$k} = $v;
			}
		}
		eval("?>".$str);
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}
?>
