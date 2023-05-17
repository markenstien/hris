<?php 
	$href = URL.DS._route('auth:login');

	$link = "<a href='{$href}'>{$href}</a>";
	$html = <<<EOF
		<p> {$text} </p>
		Login Here {$link}</p>
	EOF;

	$html = wEmailComplete($html);
	return $html;
?>
