	<?php 
		$this->widget('GridView', array(
		    'id' => 'reg-grid',
		    'dataProvider' => $model->search(),
		    'cssFile' => false,
		    'itemsCssClass' => 'tab-reg',
		    'columns' => array(
		        'gai_number',
		 		'username',
				'create_time',
		        array(
					'name' => 'ip',
					'value' => 'Tool::int2ip($data->ip)',
					'type' => 'raw',
				),
		    ),
		));
	?>
