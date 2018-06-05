<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
		echo $this->Html->css('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css');
		echo $this->Html->css('https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css');
		echo $this->Html->css('Spotify.spotify.css');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div class="container-fluid">
	<div class="row">
	    <div class="col-xs-12 col-sm-12 col-md-1 side-nav clean-paddings">
	      <nav class="navbar">
	         <ul class="nav">
	           <li class="brand-icon"><a href="/"><span class="fa fa-spotify"></span></a></li>
	           <li><a href="/spotify/buscar"><span class="fa fa-search"></span>Buscar</a></li>
	           <li><a href="/spotify/busqueda-avanzada"><span class="fa fa-search-plus"></span>Búsqueda Avanzada</a></li>
	        </ul>
	      </nav>
	    </div>
		<div class="col-xs-12 col-sm-11 col-md-11 col-md-offset-1">

			<?php echo $this->Flash->render(); ?>

			<?php echo $this->fetch('content'); ?>
			<?php echo $this->element('sql_dump'); ?>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<?php echo $this->Html->script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'); ?>
	<?php echo $this->Html->script('Spotify.full_search.js'); ?>
</body>
</html>
