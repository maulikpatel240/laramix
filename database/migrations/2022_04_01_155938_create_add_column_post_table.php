<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('devices', function (Blueprint $table) {
        //     $table->id();
        //     $table->enum('type', ['android', 'ios', 'web', 'unity'])->default(null)->nullable();
        //     $table->string('udid', 40)->nullable()->index()->comment("--header 'x-device-udid: unique-device-udid'");
        //     $table->string('os', 15)->nullable()->index()->comment("--header 'x-device-os: Android'");
        //     $table->string('os_version')->nullable()->comment("--header 'x-device-os-version: 8.0'");
        //     $table->string('manufacturer')->nullable()->comment("--header 'x-device-manufacturer: Samsung''");
        //     $table->string('model')->nullable()->comment("--header 'x-device-model: Galaxy S10'");
        //     $table->string('fcm_token')->nullable()->comment("--header 'x-device-fcm-token: firebase-cloud-messaging-token''");
        //     $table->string('app_version', 20)->nullable()->index()->comment("--header 'x-device-app-version: 1.0.1'");
        //     $table->string('ipv4', 50)->nullable()->index()->comment("127.0.0.1");
        //     $table->timestamps();
        // });

        // Schema::table('devices', function (Blueprint $table) {
        //     $table->unsignedBigInteger('member_id')->after('id')->nullable()->comment('Type Of User');
        //     $table->foreign('member_id')->references('id')->on('user')->onUpdate('cascade')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('add_column_post');
    }
};
