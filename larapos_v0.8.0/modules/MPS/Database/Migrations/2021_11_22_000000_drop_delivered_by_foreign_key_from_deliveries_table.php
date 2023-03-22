<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropDeliveredByForeignKeyFromDeliveriesTable extends Migration
{
    public function down()
    {
    }

    public function up()
    {
        Schema::table('deliveries', function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $indexes = DB::connection()->getDoctrineSchemaManager()->listTableIndexes('deliveries');
                foreach ($indexes as $index_name => $index_data) {
                    if ($index_name == 'deliveries_delivered_by_foreign') {
                        $table->dropForeign(['delivered_by']);
                    }
                }
            }
        });
    }
}
