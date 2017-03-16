<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Alaxos\Model\Entity\TimezonedTrait;

/**
 * User Entity
 *
 * @property int $id
 * @property int $role_id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $external_uid
 * @property \Cake\I18n\Time $last_login_date
 * @property \Cake\I18n\Time $created
 * @property int $created_by
 * @property \Cake\I18n\Time $modified
 * @property int $modified_by
 *
 * @property \App\Model\Entity\User $creator
 * @property \App\Model\Entity\User $editor
 * @property \App\Model\Entity\Role $role
 */
class User extends Entity
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
        '*' => true,
        'id' => false
    ];
}
