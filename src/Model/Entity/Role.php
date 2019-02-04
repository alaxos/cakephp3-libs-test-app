<?php
namespace App\Model\Entity;
use Alaxos\Model\Entity\TimezonedTrait;

use Cake\ORM\Entity;

/**
 * Role Entity
 *
 * @property int $id
 * @property string $name
 * @property \Cake\I18n\Time $created
 * @property int|null $created_by
 * @property \Cake\I18n\Time $modified
 * @property int|null $modified_by
 *
 * @property \App\Model\Entity\User $creator
 * @property \App\Model\Entity\User $editor
 * @property \App\Model\Entity\User[] $users
 */
class Role extends Entity
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
        'name' => true,
        'created' => true,
        'created_by' => true,
        'modified' => true,
        'modified_by' => true,
        'creator' => true,
        'editor' => true,
        'users' => true
    ];
}
