<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameItemIdToProductIdInCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            if (Schema::hasColumn('comments', 'item_id')) {
                $table->renameColumn('item_id', 'product_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_id_in_comments', function (Blueprint $table) {
            $table->renameColumn('product_id', 'item_id');
        });
    }
}
