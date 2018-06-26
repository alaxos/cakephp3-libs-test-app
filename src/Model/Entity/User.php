<?php
namespace App\Model\Entity;
use Alaxos\Model\Entity\TimezonedTrait;

use Cake\ORM\Entity;

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
        'role_id' => true,
        'firstname' => true,
        'lastname' => true,
        'email' => true,
        'external_uid' => true,
        'last_login_date' => true,
        'created' => true,
        'created_by' => true,
        'modified' => true,
        'modified_by' => true,
        'role' => true
    ];

    public function _getFullname()
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}
