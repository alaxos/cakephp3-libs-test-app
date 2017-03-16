
<div class="users view">
	<h2><?php echo ___('user'); ?></h2>
	
	<div class="panel panel-default">
		<div class="panel-heading">
		<?php
		echo $this->Navbars->actionButtons(['buttons_group' => 'view', 'model_id' => $user->id]);
		?>
		</div>
		<div class="panel-body">
			<dl class="dl-horizontal">
			
				<dt><?php echo __('Role'); ?></dt>
				<dd>
					<?php echo $user->has('role') ? $this->Html->link($user->role->name, ['controller' => 'Roles', 'action' => 'view', $user->role->id]) : '' ?>
				</dd>
					
				<dt><?= ___('firstname'); ?></dt>
				<dd>
					<?php 
					echo h($user->firstname);
					?>
				</dd>
				
				<dt><?= ___('lastname'); ?></dt>
				<dd>
					<?php 
					echo h($user->lastname);
					?>
				</dd>
				
				<dt><?= ___('email'); ?></dt>
				<dd>
					<?php 
					echo h($user->email);
					?>
				</dd>
				
				<dt><?= ___('external_uid'); ?></dt>
				<dd>
					<?php 
					echo h($user->external_uid);
					?>
				</dd>
				
				<dt><?= ___('last_login_date'); ?></dt>
				<dd>
					<?php 
					echo h($user->to_display_timezone('last_login_date'));
					?>
				</dd>
				
			</dl>
			<?php 
			echo $this->element('Alaxos.create_update_infos', ['entity' => $user], ['plugin' => 'Alaxos']);
			?>
			<div>
			</div>
		</div>
	</div>
</div>
	
