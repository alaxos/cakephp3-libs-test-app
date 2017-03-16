<div class="users index">

	<h2><?= ___('users'); ?></h2>

	<div class="panel panel-default">
		<div class="panel-heading">
		<?php
		echo $this->Navbars->actionButtons(['paginate_infos' => true, 'select_pagination_limit' => true]);
		?>
		</div>
		<div class="panel-body">

			<div class="table-responsive">

			<table cellpadding="0" cellspacing="0" class="table table-striped table-hover table-condensed">
			<thead>
			<tr class="sortHeader">
				<th></th>
				<th><?php echo $this->Paginator->sort('role_id', ___('role_id')); ?></th>
				<th><?php echo $this->Paginator->sort('firstname', ___('firstname')); ?></th>
				<th><?php echo $this->Paginator->sort('lastname', ___('lastname')); ?></th>
				<th><?php echo $this->Paginator->sort('email', ___('email')); ?></th>
				<th><?php echo $this->Paginator->sort('external_uid', ___('external_uid')); ?></th>
				<th style="width:160px;"><?php echo $this->Paginator->sort('last_login_date', ___('last_login_date')); ?></th>
				<th style="width:160px;"><?php echo $this->Paginator->sort('created', ___('created')); ?></th>
				<th style="width:160px;"><?php echo $this->Paginator->sort('modified', ___('modified')); ?></th>
				<th class="actions"></th>
			</tr>
			<tr class="filterHeader">
				<td>
				<?php
				echo $this->AlaxosForm->checkbox('_Tech.selectAll', ['id' => 'TechSelectAll']);

				echo $this->AlaxosForm->create($search_entity, array('url' => [], 'class' => 'form-horizontal', 'role' => 'form', 'novalidate' => 'novalidate'));
				?>
				</td>
				<td>
					<?php
					echo $this->AlaxosForm->filterField('role_id');
					?>
				</td>
				<td>
					<?php
					echo $this->AlaxosForm->filterField('firstname');
					?>
				</td>
				<td>
					<?php
					echo $this->AlaxosForm->filterField('lastname');
					?>
				</td>
				<td>
					<?php
					echo $this->AlaxosForm->filterField('email');
					?>
				</td>
				<td>
					<?php
					echo $this->AlaxosForm->filterField('external_uid');
					?>
				</td>
				<td>
					<?php
					echo $this->AlaxosForm->filterDate('last_login_date');
					?>
				</td>
				<td>
					<?php
					echo $this->AlaxosForm->filterDate('created');
					?>
				</td>
				<td>
					<?php
					echo $this->AlaxosForm->filterDate('modified');
					?>
				</td>
				<td>
					<?php
					echo $this->AlaxosForm->button(___d('alaxos', 'filter'), ['class' => 'btn btn-default']);
					echo $this->AlaxosForm->end();
					?>
				</td>
			</tr>
			</thead>

			<tbody>
			<?php foreach ($users as $i => $user): ?>
				<tr>
					<td>
						<?php
						echo $this->AlaxosForm->checkBox('User.' . $i . '.id', array('value' => $user->id, 'class' => 'model_id'));
						?>
					</td>
					<td>
						<?php echo $user->has('role') ? $this->Html->link($user->role->name, ['controller' => 'Roles', 'action' => 'view', $user->role->id]) : ''; ?>
					</td>
					<td>
						<?php echo h($user->firstname) ?>
					</td>
					<td>
						<?php echo h($user->lastname) ?>
					</td>
					<td>
						<?php echo h($user->email) ?>
					</td>
					<td>
						<?php echo h($user->external_uid) ?>
					</td>
					<td>
						<?php echo h($user->to_display_timezone('last_login_date')); ?>
					</td>
					<td>
						<?php echo h($user->to_display_timezone('created')); ?>
					</td>
					<td>
						<?php echo h($user->to_display_timezone('modified')); ?>
					</td>
					<td class="actions">
						<?php
// 						echo $this->Navbars->actionButtons(['buttons_group' => 'list_item', 'buttons_list_item' => [['view', 'edit', 'delete']], 'model_id' => $user->id]);
						?>

						<?php
// 						echo $this->Html->link('<span class="glyphicon glyphicon-search"></span> ' . __d('alaxos', 'view'), ['action' => 'view', $user->id], ['class' => 'to_view', 'escape' => false]);
// 						echo ' ';
// 						echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> ' . __d('alaxos', 'edit'), ['action' => 'edit', $user->id], ['escape' => false]);
// 						echo ' ';
// 						echo $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span> ' . __d('alaxos', 'delete'), ['action' => 'delete', $user->id], ['confirm' => __d('alaxos', 'Are you sure you want to delete element # {0}?', $user->id), 'escape' => false]);
						?>

						<?php
						echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', ['action' => 'view', $user->id], ['class' => 'to_view', 'escape' => false]);
						echo '&nbsp;&nbsp;';
						echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $user->id], ['escape' => false]);
						echo '&nbsp;&nbsp;';
						echo $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span>', ['action' => 'delete', $user->id], ['confirm' => __d('alaxos', 'Are you sure you want to delete element # {0}?', $user->id), 'escape' => false]);
						?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>

			</table>

			</div>

			<?php
			if(isset($users) && $users->count() > 0)
			{
				echo '<div class="row">';
				echo '<div class="col-md-1">';
				echo $this->AlaxosForm->postActionAllButton(__d('alaxos', 'delete all'), ['action' => 'delete_all'], ['confirm' => __d('alaxos', 'do you really want to delete the selected items ?')]);
				echo '</div>';
				echo '</div>';
			}
			?>

			<div class="paging text-center">
				<ul class="pagination pagination-sm">
				<?php
				$this->Paginator->templates(['ellipsis' => '<li class="ellipsis"><span>...</span></li>']);
				echo $this->Paginator->prev('< ' . __d('alaxos', 'previous'));
				echo $this->Paginator->numbers(['first' => 2, 'last' => 2]);
				echo $this->Paginator->next(__d('alaxos', 'next') . ' >');
				?>
				</ul>
			</div>

		</div>
	</div>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	Alaxos.start();
});
</script>