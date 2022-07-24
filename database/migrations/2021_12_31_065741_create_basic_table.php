<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lang', function (Blueprint $table) {
            $table->id();
            $table->string('lang_family', 100)->nullable()->comment("language family of country region");
            $table->string('name', 100)->comment("Local English language name");
            $table->string('3letter', 10)->nullable()->comment("ISO 639-2 Code");
            $table->string('2letter', 10)->nullable()->comment("ISO 639-1 Code");
            $table->string('native', 100)->nullable()->comment("Native local Language name");
            $table->text('note')->nullable()->comment("Language realated notes");
            $table->boolean('is_active')->default(1); // 1:Active, 0:Inactive
            $table->dateTime('is_active_at')->nullable();
            $table->timestamps();
        });

        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('lang_key', 100);
            $table->string('type', 400);
            $table->timestamps();
        });

        Schema::create('role', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->enum('panel', ['Backend', 'Frontend', 'Common'])->default('Backend'); // 1:Active, 0:Inactive
            $table->boolean('is_active')->default(1); // 1:Active, 0:Inactive
            $table->dateTime('is_active_at')->nullable();
            $table->timestamps();
        });

        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->string('auth_key', 80)
                ->unique()
                ->nullable();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 100)->unique();
            $table->string('email_otp', 10)->nullable();
            $table->boolean('email_verified')->default(0); // 1:Verify, 0:Inverify
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('password_reset_token', 100)->nullable();
            $table->string('verification_token', 100)->nullable();
            $table->string('phone_number', 20);
            $table->string('phone_number_otp', 10)->nullable();
            $table->boolean('phone_number_verified')->default(0); // 1:Verify, 0:Inverify
            $table->timestamp('phone_number_verified_at')->nullable();
            $table->string('profile_photo', 100)->nullable();
            $table->rememberToken();
            $table->boolean('is_active')->default(1); // 1:Active, 0:Inactive
            $table->dateTime('is_active_at')->nullable();
            $table->timestamps();
        });

        Schema::table('admin', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->after('id')->nullable()->comment('Type Of Role');
            $table->foreign('role_id')->references('id')->on('role')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        //php artisan make:migration create_failed_jobs_table
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        //php artisan make:migration create_modules_table
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->enum('panel', ['Backend', 'Frontend', 'Common'])->default('Backend'); // 1:Active, 0:Inactive
            $table->string('title', 100);
            $table->string('controller', 100)->nullable();
            $table->string('action', 100)->nullable();
            $table->string('icon', 55);
            $table->enum('functionality', ['crud', 'singleview', 'other', 'none'])->default('crud');
            $table->enum('type', ['Menu', 'Submenu', 'Subsubmenu'])->default('Menu');
            $table->integer('parent_menu_id', false, true)->nullable();
            $table->integer('parent_submenu_id', false, true)->nullable();
            $table->integer('menu_position', false, true)->nullable();
            $table->integer('submenu_position', false, true)->nullable();
            $table->boolean('is_hiddden')->default(0);
            $table->boolean('is_active')->default(1); // 1:Active, 0:Inactive
            $table->dateTime('is_active_at')->nullable();
            $table->timestamps();
        });

        //php artisan make:migration create_permission_table
        Schema::create('permission', function (Blueprint $table) {
            $table->id();
            $table->enum('panel', ['Backend', 'Frontend', 'App', 'Common'])->default('Backend');
            $table->string('title', 200);
            $table->string('name', 100);
            $table->string('controller', 100);
            $table->string('action', 100);
        });

        Schema::table('permission', function (Blueprint $table) {
            $table->unsignedBigInteger('module_id')->after('id')->nullable()->comment('Type Of Module');
            $table->foreign('module_id')->references('id')->on('modules')->onUpdate('cascade')->onDelete('cascade');
        });

        //php artisan make:migration create_role_access_table
        Schema::create('role_access', function (Blueprint $table) {
            $table->id();
            $table->boolean('access')->default(1); // 1:Active, 0:Inactive
            $table->timestamps();
        });

        Schema::table('role_access', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->after('id')->nullable()->comment('Type Of Role');
            $table->foreign('role_id')->references('id')->on('role')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('permission_id')->after('role_id')->nullable()->comment('Type Of Permission');
            $table->foreign('permission_id')->references('id')->on('permission')->onUpdate('cascade')->onDelete('cascade');
        });

        //php artisan make:migration create_configuration_table
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('value')->nullable();
            $table->text('description')->nullable();
            $table->enum('type', ['Text', 'Textarea', 'File', 'Date', 'Time', 'Datetime', 'Radio', 'Checkbox', 'Select', 'Other'])->default('Text');
            $table->boolean('is_active')->default(1); // 1:Active, 0:Inactive
            $table->dateTime('is_active_at')->nullable();
            $table->timestamps();
        });

        //php artisan make:migration create_custom_pages_table
        Schema::create('custom_pages', function (Blueprint $table) {
            $table->id();
            $table->string('language', 255)->nullable();
            $table->string('name')->unique();
            $table->text('title');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(1); // 1:Active, 0:Inactive
            $table->dateTime('is_active_at')->nullable();
            $table->timestamps();
        });

        //php artisan make:migration create_email_templates_table
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('title');
            $table->string('subject')->nullable();
            $table->text('html');
            $table->enum('panel', ['Backend', 'Web', 'App', 'Common'])->default('Common');
            $table->boolean('is_active')->default(1); // 1:Active, 0:Inactive
            $table->dateTime('is_active_at')->nullable();
            $table->timestamps();
        });

        //php artisan make:migration create_email_templates_field_table
        Schema::create('email_templates_field', function (Blueprint $table) {
            $table->id();
            $table->string('field');
            $table->text('description');
            $table->enum('is_default', [1, 0])->default(0); // 1:Active, 0:Inactive
            $table->timestamps();
        });

        Schema::table('email_templates_field', function (Blueprint $table) {
            $table->unsignedBigInteger('email_template_id')->after('id')->nullable()->comment('Type Of Email Template');
            $table->foreign('email_template_id')->references('id')->on('email_templates')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('user');
    }
}
