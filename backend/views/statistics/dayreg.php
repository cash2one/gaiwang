	<?php 
		$this->widget('GridView', array(
		    'id' => 'reg-grid',
		    'dataProvider' => $model->getDayReg(),
		    'cssFile' => false,
		    'itemsCssClass' => 'tab-reg',
		    'columns' => array(
		 		'username',
		        'gai_number',
		        'mobile',
				'register_time',
				'referrals_id',
		        array(
					'name' => 'is_enterprise',
					'value' => 'Member::isEnterprise($data->is_enterprise)',
					'type' => 'raw',
				),
		        array(
					'name' => 'register_type',
					'value' => 'Member::registerType($data->register_type)',
					'type' => 'raw',
				),
		    ),
		));
	?>
