<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateModifierOptionsTable extends Migration
{
    public function up()
    {
        Schema::table('modifier_options', function (Blueprint $table) {
            $table->dropUnique(['modifier_id', 'item_id']);
        });
    }
}
