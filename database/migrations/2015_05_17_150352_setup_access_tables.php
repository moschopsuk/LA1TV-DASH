<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetupAccessTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table(config('auth.table'), function ($table) {
			$table->boolean('status')->after('password')->default(true);
		});

		Schema::create(config('site.tables.roles'), function ($table) {
			$table->increments('id')->unsigned();
			$table->string('name')->unique();
			$table->timestamps();
		});

		Schema::create(config('site.tables.assigned_roles'), function ($table) {
			$table->increments('id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('role_id')->unsigned();
			$table->foreign('user_id')
				->references('id')
				->on(config('auth.table'))
				->onUpdate('cascade')
				->onDelete('cascade');
			$table->foreign('role_id')->references('id')->on(config('site.tables.roles'));
		});

		Schema::create(config('site.tables.permissions'), function ($table) {
			$table->increments('id')->unsigned();
			$table->string('name')->unique();
			$table->string('display_name');
			$table->boolean('system')->default(false);
			$table->timestamps();
		});

		Schema::create(config('site.tables.permission_role'), function ($table) {
			$table->increments('id')->unsigned();
			$table->integer('permission_id')->unsigned();
			$table->integer('role_id')->unsigned();
			$table->foreign('permission_id')
				->references('id')
				->on(config('site.tables.permissions'));
			$table->foreign('role_id')
				->references('id')
				->on(config('site.tables.roles'));
		});

		Schema::create(config('site.tables.permission_user'), function ($table) {
			$table->increments('id')->unsigned();
			$table->integer('permission_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->foreign('permission_id')
				->references('id')
				->on(config('site.tables.permissions'));
			$table->foreign('user_id')
				->references('id')
				->on(config('auth.table'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table(config('auth.table'), function(Blueprint $table)
		{
			$table->dropColumn('status');
		});

		Schema::table(config('site.tables.assigned_roles'), function (Blueprint $table) {
			$table->dropForeign(config('site.tables.assigned_roles').'_user_id_foreign');
			$table->dropForeign(config('site.tables.assigned_roles').'_role_id_foreign');
		});

		Schema::table(config('site.tables.permission_role'), function (Blueprint $table) {
			$table->dropForeign(config('site.tables.permission_role').'_permission_id_foreign');
			$table->dropForeign(config('site.tables.permission_role').'_role_id_foreign');
		});

		Schema::table(config('site.tables.permission_user'), function (Blueprint $table) {
			$table->dropForeign(config('site.tables.permission_user').'_permission_id_foreign');
			$table->dropForeign(config('site.tables.permission_user').'_user_id_foreign');
		});

		Schema::drop(config('site.tables.assigned_roles'));
		Schema::drop(config('site.tables.permission_role'));
		Schema::drop(config('site.tables.permission_user'));
		Schema::drop(config('site.tables.roles'));
		Schema::drop(config('site.tables.permissions'));
	}

}
