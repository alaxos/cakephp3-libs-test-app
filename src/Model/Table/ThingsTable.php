<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Things Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Thing get($primaryKey, $options = [])
 * @method \App\Model\Entity\Thing newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Thing[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Thing|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Thing saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Thing patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Thing[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Thing findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ThingsTable extends AppTable
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('things');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Alaxos.UserLink');
        $this->addBehavior('Alaxos.Timezoned');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->integer('int_field')
            ->allowEmptyString('int_field');

        $validator
            ->allowEmptyString('smallint_field');

        $validator
            ->allowEmptyString('bigint_field');

        $validator
            ->decimal('decimal_field')
            ->allowEmptyString('decimal_field');

        $validator
            ->numeric('float_field')
            ->allowEmptyString('float_field');

        $validator
            ->numeric('double_field')
            ->allowEmptyString('double_field');

        $validator
            ->numeric('real_field')
            ->allowEmptyString('real_field');

        $validator
            ->boolean('boolean_field')
            ->requirePresence('boolean_field', 'create')
            ->allowEmptyString('boolean_field', false);

        $validator
            ->date('date_field')
            ->allowEmptyDate('date_field');

        $validator
            ->dateTime('datetime_field')
            ->allowEmptyDateTime('datetime_field');

        $validator
            ->integer('created_by')
            ->allowEmptyString('created_by');

        $validator
            ->integer('modified_by')
            ->allowEmptyString('modified_by');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
