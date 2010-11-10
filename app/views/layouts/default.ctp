<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $title_for_layout; ?> - <?php __('Layarizar'); ?></title>
    <?php
        echo $javascript->link(array('jquery/jquery.min'));
	echo $layout->js();
        echo $html->css(array(
            'reset',
            '960',
            '/ui-themes/smoothness/jquery-ui-1.7.2.css',
            'admin',
            'thickbox',
        ));
        echo $javascript->link(array(
            'jquery/jquery-ui-1.7.2.custom.min',
            'jquery/jquery.uuid',
            'jquery/jquery.cookie',
            'jquery/jquery.collapsor',
            'jquery/jquery.tipsy',
            'admin',
        ));
        echo $scripts_for_layout;
    ?>
</head>
<body>
	<div id="container">
	<div id="header">
			<h1><?php echo $this->Html->link(__('Layarizar', true), '/'); ?><?php if (isset($usuario)) { echo ' | '.$this->Html->link(__('logout', true), '/users/logout'); } ?></h1>
		</div>

		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $content_for_layout; ?>

		</div>
		<div id="footer">
                        <?php echo $this->Html->link(
					'geekia',
					'http://www.geekia.es/',
					array('target' => '_blank', 'escape' => false)
				);
			?> | 
			<?php echo $this->Html->link(
					'cakephp',
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<!--
	<?php// echo $this->element('sql_dump'); ?>
	-->
</body>
</html>