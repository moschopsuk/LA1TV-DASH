<?php namespace App\LA1TV\Core\Permissions;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 * @package App
 */
class Permission extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table;

	/**
	 *
	 */
	public function __construct()
	{
		$this->table = config('site.tables.permissions');
	}

	/**
	 * Many-to-Many relations with Roles.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function roles()
	{
		return $this->belongsToMany(config('site.role'), config('site.tables.permission_role'), 'permission_id', 'role_id');
	}

	/**
	 * Many-to-Many relations with Users.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users()
	{
		return $this->belongsToMany(config('auth.model'), config('site.tables.permission_user'), 'permission_id', 'user_id');
	}

	/**
	 * Before delete all constrained foreign relations.
	 *
	 * @return bool
	 */
	public function beforeDelete()
	{
		DB::table(config('site.tables.permission_role'))->where('permission_id', $this->id)->delete();
	}
}