<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateColProductInternal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_internal_detail', function (Blueprint $table) {
            $table->string('api_standard_update_erp_status_success_url')->nullable();
            $table->string('api_key_erp')->nullable();
        });

        DB::table('product_internal_detail')->update([
            "api_standard_update_erp_status_success_url" => "http://dev-erp.ttcglobal.network:881/apibot/service.php?api_connect=TTCG_ERP&event_chk=RV",
            "api_key_erp" => "dHRjZ2FwaTpCWVpuUnExVGNN"
        ]);
    }

    /*
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        //
    }
}

