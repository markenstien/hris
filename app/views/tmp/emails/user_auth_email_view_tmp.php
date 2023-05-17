<?php 
	$href = URL.DS._route('auth:login');

	$link = "<a href='{$href}'>Here</a>";
	$html = <<<EOF
		<h5>Good Day! {$user->first_name}</h5>
		<p>Here is your credential for our system {$system_name}</p>
		<table cellpadding="2" border="1px">
			<tr>
				<td>Username</td>
				<td>Password</td>
			</tr>
			<tr>
				<td>{$user->email}</td>
				<td>{$user->password}</td>
			</tr>
		</table>
		<p>Login {$link}</p>
	EOF;

	$html = wEmailComplete($html);
	return $html;
?>
