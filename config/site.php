<?php

/*
 * Site configurations
 * TODO: Move to a DB to allow easier change to settings
 */

return array(

	/*
	 * Role model used by Access to create correct relations. Update the role if it is in a different namespace.
	*/
	'role' => 'App\LA1TV\Core\Roles\Role',

	/*
	 * Permission model used by Access to create correct relations.
	 * Update the permission if it is in a different namespace.
	 */
	'permission' => 'App\LA1TV\Core\Permissions\Permission',


	'tables' => [
		/*
		 * Roles table used by Access to save roles to the database.
		 */
		'roles' => 'roles',

		/*
		 * Permissions table used by Access to save permissions to the database.
		 */
		'permissions' => 'permissions',

		/*
		 * permission_role table used by Access to save relationship between permissions and roles to the database.
		 */
		'permission_role' => 'permission_role',

		/*
		 * permission_user table used by Access to save relationship between permissions and users to the database.
		 * This table is only for permissions that belong directly to a specific user and not a role
		 */
		'permission_user' => 'permission_user',

		/*
		 * assigned_roles table used by Access to save assigned roles to the database.
		 */
		'assigned_roles' => 'assigned_roles',

	],

	/*
	 * Configurations for the user
	 */
	'users' => [
		/*
		 * Whether or not the user has to confirm their email when signing up
		 */
		'confirm_email' => true,
	],

);

