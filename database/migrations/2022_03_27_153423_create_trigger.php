<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateTrigger extends Migration
{

    public function up()
    {
        // DB::unprepared("CREATE TRIGGER `owner_family_member_remove` AFTER DELETE ON `family_member` FOR EACH ROW BEGIN IF (old.type = 'Owner') THEN DELETE FROM user WHERE user.id = old.member_id; END IF; END");
    }

    public function down()
    {
        // DB::unprepared('DROP TRIGGER IF EXISTS `Owner_family_member_remove`;');
    }
}
