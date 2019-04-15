<?php
namespace App\Model\Entity;
use Alaxos\Model\Entity\TimezonedTrait;

use Cake\ORM\Entity;

/**
 * Thing Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string|null $description
 * @property int|null $int_field
 * @property int|null $smallint_field
 * @property int|null $bigint_field
 * @property float|null $decimal_field
 * @property float|null $float_field
 * @property float|null $double_field
 * @property float|null $real_field
 * @property bool $boolean_field
 * @property \Cake\I18n\Date|null $date_field
 * @property \Cake\I18n\Time|null $datetime_field
 * @property \Cake\I18n\Time $created
 * @property int|null $created_by
 * @property \Cake\I18n\Time $modified
 * @property int|null $modified_by
 *
 * @property \App\Model\Entity\User $creator
 * @property \App\Model\Entity\User $editor
 * @property \App\Model\Entity\User $user
 */
class Thing extends Entity
{
    use TimezonedTrait;

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'user_id' => true,
        'name' => true,
        'description' => true,
        'int_field' => true,
        'smallint_field' => true,
        'bigint_field' => true,
        'decimal_field' => true,
        'float_field' => true,
        'double_field' => true,
        'real_field' => true,
        'boolean_field' => true,
        'date_field' => true,
        'datetime_field' => true,
        'created' => true,
        'created_by' => true,
        'modified' => true,
        'modified_by' => true,
        'creator' => true,
        'editor' => true,
        'user' => true
    ];
}
