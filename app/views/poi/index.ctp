<h2><?php echo __('Layarizer', true); ?></h2>
<?php
$javascript->link(array(
			'http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAFGUgGaRTTSdRGB1HbN19ZBQP7c2vWk8Sah2Xi6SulclfOeI0WxS-UcFU8d82ETgejnKtGVrMbbeJWw',
					'poi'), false);
?>

<table>
    <tr>
        <th><?php echo $paginator->sort('ID', 'id'); ?></th> 
		<th><?php echo $paginator->sort('Titulo', 'title'); ?></th> 
        <th>Latitud</th>
        <th>Longitud</th>
		<th>&nbsp;</th>
    </tr>
    <!-- Aqui se hace el ciclo que recorre nuestros arreglo $posts , imprimiendo la información de cada post-->
    <?php foreach ($pois as $poi): ?>
    <tr>
        <td><?php echo $poi['Poi']['id']; ?></td>
        <td><?php echo $html->link($poi['Poi']['title'], "/poi/editar/".$poi['Poi']['id']); ?></td>
        <td><?php echo $poi['Poi']['lat']; ?></td>
        <td><?php echo $poi['Poi']['lon']; ?></td>
		<td><?php echo $html->link('Eliminar',array('controller'=>'poi', 'action'=>'borrar', $poi['Poi']['id']),array(),"¿Está seguro de eliminar este POI?");?>
</td>
    </tr>
    <?php endforeach; ?>
	 <?php echo $html->link('Añadir POI', '/poi/add', array('class'=>'button')); ?>
</table>
	<?php echo $paginator->numbers(); ?>
<!-- Muestra los enlaces para Anterior y Siguiente -->
<div class="navega">
<?php
	echo $paginator->prev('« Anterior ', null, null, array('class' => 'disabled'));
	echo $paginator->next(' Siguiente »', null, null, array('class' => 'disabled'));
?> 
</div>
<div class="mini">
	<?php
echo $paginator->counter(array(
	'format' => 'Pagina %page% de %pages%, mostrando %current% registros de un total de %count%, inicio %start%, fin en %end%'
)); 
?>
</div>
<div class="mapa">
<?php
$avg_lat = 0;
$avg_lon = 0;
$count=0;
foreach($pois as $n=>$poi){
$imagen='';
if ($poi['Poi']['imageURL']) { $imagen="<img src='".$poi['Poi']['imageURL']."'/>"; }
$editar=$imagen."<br/><a href='/poi/editar/".$poi['Poi']['id']."'>Editar</a> | <a href='/poi/borrar/".$poi['Poi']['id']."' onclick='return confirm(&#039;¿Está seguro de eliminar este POI?&#039;);'>Eliminar</a>";
	$pois[$n]['Poi']['title'] = "<strong>".$poi['Poi']['title']."</strong><br/>";
	$pois[$n]['Poi']['latitude'] = $poi['Poi']['lat'];
	$pois[$n]['Poi']['longitude'] = $poi['Poi']['lon'];
	$pois[$n]['Poi']['html'] = $poi['Poi']['line2'].$editar;
	}
$avg_lat=36.845148;
$avg_lon=-2.452011;
$default = array('type'=>'0','zoom'=>14,'lat'=>$avg_lat,'long'=>$avg_lon);
echo $googleMap->map($default, $style = 'width:100%; height: 750px' );
echo $googleMap->addMarkers($pois);
?>
</div>
