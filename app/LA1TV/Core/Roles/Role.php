<?php namespace App\LA1TV\Core\Roles;

use Illuminate\Database\Eloquent\Model;
/**
 * Class Role
 * @package App
 */
class Role extends Model {

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
		$this->table = config('site.tables.roles');
	}

	/**
	 * Many-to-Many relations with Users.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users()
	{
		return $this->belongsToMany(config('auth.model'), config('access.assigned_roles_table'), 'role_id', 'user_id');
	}

	/**
	 * Many-to-Many relations with Permission.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function permissions()
	{
		return $this->belongsToMany(config('site.permission'), config('site.tables.permission_role'), 'role_id', 'permission_id');
	}

	/**
	 * Before delete all constrained foreign relations
	 *
	 * @return bool
	 */
	public function beforeDelete()
	{
		DB::table(config('site.tables.assigned_roles'))->where('role_id', $this->id)->delete();
		DB::table(config('site.tables.permission_role'))->where('role_id', $this->id)->delete();
	}

	/**
	 * Save the inputted permissions.
	 *
	 * @param mixed $inputPermissions
	 *
	 * @return void
	 */
	public function savePermissions($inputPermissions)
	{
		if (! empty($inputPermissions)) {
			$this->permissions()->sync($inputPermissions);
		} else {
			$this->permissions()->detach();
		}
	}

	/**
	 * Attach permission to current role.
	 *
	 * @param object|array $permission
	 *
	 * @return void
	 */
	public function attachPermission($permission)
	{
		if (is_object($permission)) {
			$permission = $permission->getKey();
		}
		if (is_array($permission)) {
			$permission = $permission['id'];
		}
		$this->permissions()->attach($permission);
	}

	/**
	 * Detach permission form current role.
	 *
	 * @param object|array $permission
	 *
	 * @return void
	 */
	public function detachPermission($permission)
	{
		if (is_object($permission))
			$permission = $permission->getKey();
		if (is_array($permission))
			$permission = $permission['id'];
		$this->permissions()->detach($permission);
	}

	/**
	 * Attach multiple permissions to current role.
	 *
	 * @param mixed $permissions
	 *
	 * @return void
	 */
	public function attachPermissions($permissions)
	{
		foreach ($permissions as $permission) {
			$this->attachPermission($permission);
		}
	}

	/**
	 * Detach multiple permissions from current role
	 *
	 * @param mixed $permissions
	 *
	 * @return void
	 */
	public function detachPermissions($permissions)
	{
		foreach ($permissions as $permission) {
			$this->detachPermission($permission);
		}
	}
}