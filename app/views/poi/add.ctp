<h2>Nuevo POI</h2>
<?php

//debug($this->data);
$javascript->link(array(
			'http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAFGUgGaRTTSdRGB1HbN19ZBQP7c2vWk8Sah2Xi6SulclfOeI0WxS-UcFU8d82ETgejnKtGVrMbbeJWw',
					'poi'), false);
echo $form->create(null, array('action' => 'add','class'=>'form','accept-charset'=>'UTF-8','name'=>'poi','type' => 'file'));
?>
<div class="tabs">
<ul>
                    <li><a href="#poi-main"><span><?php __('POI'); ?></span></a></li>
                    <li><a href="#poi-acciones"><span><?php __('Acciones'); ?></span></a></li>
                </ul>
				 <div id="poi-main">
<?php
$_options = array(
	    'tipo' => array(
                'legend'   => 'Tipo',
                'default'   => '1',
		'type' => 'radio',
                'div' => array('class' => 'radio'),
		'options' => array(
                            '1'=>'Cajero',
                            '2'=>'Oficina',
			    '3'=>'Ambos'
                        ),
            ),
        );
echo $form->input('type',$_options['tipo']);	
echo $form->inputs(array(
		'legend' => __('', true),
		'title'=>array('label'=>'Titulo'),
		'lat'=>array('label'=>'Latitud','readonly'=>'readonly','default'=>'36.845148'),
		'lon'=>array('label'=>'Longitud','readonly'=>'readonly','default'=>'-2.452011')));
echo $form->file('file');
		//'imageURL'=>array('label'=>'URL Imagen','type'=>'hidden'),
echo $form->inputs(array(
		'legend' => __('', true),
		'line2'=>array('label'=>'Linea 2'),
		'line3'=>array('label'=>'Linea 3'),
		'line4'=>array('label'=>'Linea 4'),
		'attribution'=>array('label'=>'Atributos'),
		'id'=>array('type'=>'hidden')
		));	
?>
<div id="mapa2" style="width:100%; height: 400px" ></div>
</div>
<div id="poi-acciones">
                    <div id="acciones-fields">
		    <?php
                            $fields = Set::combine($this->data['Action'], '{n}.label', '{n}.uri');
			    //debug($fields);
                            $fieldsKeyToId = Set::combine($this->data['Action'], '{n}.label', '{n}.id');
			    //debug($fieldsKeyToId);
                            if (count($fields) > 0) {
                                foreach ($fields AS $fieldKey => $fieldValue) {
                                    echo $action->field($fieldKey, $fieldValue, $fieldsKeyToId[$fieldKey]);
                                }
                            }
                        ?>
                        <div class="clear">&nbsp;</div>
                    </div>
                    <a href="#" class="add-action"><?php __('Añadir accion'); ?></a>
                </div>
 </div>
 <?php
echo $form->end('Añadir Poi');
?>


		<script type="text/javascript">
		//<![CDATA[

		if (GBrowserIsCompatible()) {
	map = new GMap2(document.getElementById("mapa2"));
	map.setUIToDefault();
	map.disableScrollWheelZoom();
	//map.addControl(new GOverviewMapControl());
	map.setCenter(new GLatLng(36.845148,-2.452011), 14);
	point = new GLatLng(36.845148,-2.452011);
	//geocoder = new GClientGeocoder();
	marker = new GMarker(point, {draggable: true});
	GEvent.addListener(marker,"dragstart", function() {
		  map.closeInfoWindow();
	  });
	GEvent.addListener(marker, "dragend", function() {
		document.getElementById('PoiLat').value = marker.getPoint().lat();
		document.getElementById('PoiLon').value = marker.getPoint().lng();
		//pointx = new GLatLng(marker.getPoint().lat(),marker.getPoint().lng());
		//clicked2(map, pointx);
	    
	});
	map.addOverlay(marker);
	 marker.openInfoWindowHtml('<div style="width:200px"><h2>Arrastrame!!</h2>Puedes arrastrar este icono hasta la posición donde se encuentre el punto de interes (POI), amplia y mueve el mapa hasta encontrar el punto exacto.</div>');
	}
		//]]>
		</script>