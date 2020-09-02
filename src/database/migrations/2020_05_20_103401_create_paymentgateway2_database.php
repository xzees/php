<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentgateway2Database  extends Migration
{
  public function up()
  {

    //
    // NOTE -- payment_log
    // --------------------------------------------------

    if (!Schema::hasTable('payment_log')) {
      Schema::create('payment_log', function (Blueprint $table) {
        $table->increments('id');
        $table->string('order_code', 50);
        $table->double('amount', 10, 2);
        $table->string('ip_client', 50);
        $table->text('card_holder');
        $table->unsignedInteger('card_no_front')->nullable();
        $table->unsignedInteger('card_no_rear')->unsigned();
        $table->enum('compare_status', array('No', 'Match', 'Not Match'))->nullable()->default("No");
        $table->string('successCallback', 200)->nullable();
        $table->string('failCallback', 200)->nullable();
        $table->timestamp('date')->useCurrent();
      });
    } else {
      echo "payment_log table already exist.\r\n";
    }


    //
    // NOTE -- payment_transaction
    // --------------------------------------------------

    if (!Schema::hasTable('payment_transaction')) {
      Schema::create('payment_transaction', function (Blueprint $table) {
        $table->increments('log_id')->unsigned();
        $table->string('brand_identifier', 5);
        $table->string('product_detail', 255);
        $table->string('order_code', 50);
        $table->string('amountPerMonth')->nullable();
        $table->integer('term')->nullable();
        $table->enum('payment_installment', array('I', 'F'))->nullable()->default('F');
        $table->string('payment_type', 10)->nullable();
        $table->string('amount');
        $table->enum('currency', array('THB', 'USD'))->nullable()->default('THB');
        $table->enum('ttcctype', array('V', 'M'))->default('V');
        $table->text('ttccname')->nullable();
        $table->string('source_ip', 50)->nullable();
        $table->string('dfsuccesscode', 50)->nullable();
        $table->string('dfsrc', 50)->nullable();
        $table->string('dfprc', 50)->nullable();
        $table->string('dfOrd', 50)->nullable();
        $table->string('dfeci', 50)->nullable();
        $table->string('dfpayRef', 50)->nullable();
        $table->string('dfAuthId', 50)->nullable();
        $table->string('dfpayerAuth', 50)->nullable();
        $table->string('dfHolder', 50)->nullable();
        $table->string('dfsourceIp', 50)->nullable();
        $table->string('dfipCountry', 50)->nullable();
        $table->string('dfcc1316', 50)->nullable();
        $table->string('dfMerchantId', 50)->nullable();
        $table->string('data_ip', 50)->nullable();
        $table->enum('ttc_3Dcheck', array('P', 'W'))->nullable()->default('W');
        $table->string('data_source', 10)->nullable();
        $table->dateTime('dfTxTime')->nullable();
        $table->timestamp('created_at')->useCurrent();
        $table->dateTime('updated_at')
          ->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        $table->string('successCallback', 200)->nullable();
        $table->string('failCallback', 200)->nullable();
        $table->string('gbpReferenceNo', 200)->nullable();
      });
    } else {
      echo "payment_transaction table already exist.\r\n";
    }


    //
    // NOTE -- product_internal_detail
    // --------------------------------------------------

    if (!Schema::hasTable('product_internal_detail')) {
      Schema::create('product_internal_detail', function (Blueprint $table) {
        $table->increments('id');
        $table->string('brand_identifier', 5)->nullable();
        $table->string('product_identifier', 10)->nullable();
        $table->string('product_name', 20)->nullable();
        $table->string('api_standard_retrieve_booking_url', 200)->nullable();
        $table->string('api_key', 100)->nullable();
        $table->string('payment_type', 10)->nullable();
        $table->string('price_object_key', 100)->nullable();
        $table->string('api_standard_update_payment_status_success_url', 200)->nullable();
        $table->string('api_standard_update_payment_status_fail_url', 200)->nullable();
        $table->timestamp('created_at')->useCurrent();
        $table->dateTime('updated_at')
          ->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
      });

      DB::table('product_internal_detail')->insert(
        array(
          0 =>
          array(
            'id' => 1,
            'brand_identifier' => 'TVG',
            'product_identifier' => 'flight',
            'product_name' => 'ตั๋วเครื่องบิน',
            'api_standard_retrieve_booking_url' => 'https://services.travizgo.com/flight/api/admin/flightBooking/payment',
            'api_key' => 'b2ebe9a3-2dc1-48ea-aaba-9204080a76f6',
            'payment_type' => 'credit',
            'price_object_key' => 'data.creditCardTotalSellingPrice',
            'api_standard_update_payment_status_success_url' => 'https://services.travizgo.com/flight/api/admin/payment/success',
            'api_standard_update_payment_status_fail_url' => 'https://services.travizgo.com/flight/api/admin/payment/fail',
            'created_at' => '2019-12-21 13:02:13',
            'updated_at' => '2020-01-28 09:50:48',
          ),
          1 =>
          array(
            'id' => 2,
            'brand_identifier' => 'TVG',
            'product_identifier' => 'flight',
            'product_name' => 'ตั๋วเครื่องบิน',
            'api_standard_retrieve_booking_url' => 'https://services.travizgo.com/flight/api/admin/flightBooking/payment',
            'api_key' => 'b2ebe9a3-2dc1-48ea-aaba-9204080a76f6',
            'payment_type' => 'qrcode',
            'price_object_key' => 'data.totalSellingPrice',
            'api_standard_update_payment_status_success_url' => 'https://services.travizgo.com/flight/api/admin/payment/success',
            'api_standard_update_payment_status_fail_url' => 'https://services.travizgo.com/flight/api/admin/payment/fail',
            'created_at' => '2019-12-21 13:02:13',
            'updated_at' => '2020-01-28 09:50:48',
          ),
          2 =>
          array(
            'id' => 3,
            'brand_identifier' => 'TVG',
            'product_identifier' => 'flight',
            'product_name' => 'ตั๋วเครื่องบิน',
            'api_standard_retrieve_booking_url' => 'https://services.travizgo.com/flight/api/admin/flightBooking/payment',
            'api_key' => 'b2ebe9a3-2dc1-48ea-aaba-9204080a76f6',
            'payment_type' => 'barcode',
            'price_object_key' => 'data.totalSellingPrice',
            'api_standard_update_payment_status_success_url' => 'https://services.travizgo.com/flight/api/admin/payment/success',
            'api_standard_update_payment_status_fail_url' => 'https://services.travizgo.com/flight/api/admin/payment/fail',
            'created_at' => '2019-12-21 13:02:13',
            'updated_at' => '2020-01-28 09:50:48',
          ),
          3 =>
          array(
            'id' => 4,
            'brand_identifier' => 'TVG',
            'product_identifier' => 'flight',
            'product_name' => 'ตั๋วเครื่องบิน',
            'api_standard_retrieve_booking_url' => 'https://services.travizgo.com/flight/api/admin/flightBooking/payment',
            'api_key' => 'b2ebe9a3-2dc1-48ea-aaba-9204080a76f6',
            'payment_type' => 'qrcredit',
            'price_object_key' => 'data.creditCardTotalSellingPrice',
            'api_standard_update_payment_status_success_url' => 'https://services.travizgo.com/flight/api/admin/payment/success',
            'api_standard_update_payment_status_fail_url' => 'https://services.travizgo.com/flight/api/admin/payment/fail',
            'created_at' => '2019-12-21 13:02:13',
            'updated_at' => '2020-01-28 09:50:48',
          ),
          4 =>
          array(
            'id' => 7,
            'brand_identifier' => 'TTC',
            'product_identifier' => 'flight',
            'product_name' => 'ตั๋วเครื่องบิน',
            'api_standard_retrieve_booking_url' => 'https://services.thaitravelcenter.com/flight/api/admin/flightBooking/payment',
            'api_key' => 'b2ebe9a3-2dc1-48ea-aaba-9204080a76f6',
            'payment_type' => 'credit',
            'price_object_key' => 'data.creditCardTotalSellingPrice',
            'api_standard_update_payment_status_success_url' => 'https://services.thaitravelcenter.com/flight/api/admin/payment/success',
            'api_standard_update_payment_status_fail_url' => 'https://services.thaitravelcenter.com/flight/api/admin/payment/fail',
            'created_at' => '2019-12-21 13:02:13',
            'updated_at' => '2020-01-28 09:54:53',
          ),
          5 =>
          array(
            'id' => 9,
            'brand_identifier' => 'TTC',
            'product_identifier' => 'flight',
            'product_name' => 'ตั๋วเครื่องบิน',
            'api_standard_retrieve_booking_url' => 'https://services.thaitravelcenter.com/flight/api/admin/flightBooking/payment',
            'api_key' => 'b2ebe9a3-2dc1-48ea-aaba-9204080a76f6',
            'payment_type' => 'qrcode',
            'price_object_key' => 'data.totalSellingPrice',
            'api_standard_update_payment_status_success_url' => 'https://services.thaitravelcenter.com/flight/api/admin/payment/success',
            'api_standard_update_payment_status_fail_url' => 'https://services.thaitravelcenter.com/flight/api/admin/payment/fail',
            'created_at' => '2019-12-21 13:02:13',
            'updated_at' => '2020-01-28 09:54:57',
          ),
          6 =>
          array(
            'id' => 10,
            'brand_identifier' => 'TTC',
            'product_identifier' => 'flight',
            'product_name' => 'ตั๋วเครื่องบิน',
            'api_standard_retrieve_booking_url' => 'https://services.thaitravelcenter.com/flight/api/admin/flightBooking/payment',
            'api_key' => 'b2ebe9a3-2dc1-48ea-aaba-9204080a76f6',
            'payment_type' => 'barcode',
            'price_object_key' => 'data.totalSellingPrice',
            'api_standard_update_payment_status_success_url' => 'https://services.thaitravelcenter.com/flight/api/admin/payment/success',
            'api_standard_update_payment_status_fail_url' => 'https://services.thaitravelcenter.com/flight/api/admin/payment/fail',
            'created_at' => '2019-12-21 13:02:13',
            'updated_at' => '2020-01-28 09:54:57',
          ),
          7 =>
          array(
            'id' => 11,
            'brand_identifier' => 'TTC',
            'product_identifier' => 'flight',
            'product_name' => 'ตั๋วเครื่องบิน',
            'api_standard_retrieve_booking_url' => 'https://services.thaitravelcenter.com/flight/api/admin/flightBooking/payment',
            'api_key' => 'b2ebe9a3-2dc1-48ea-aaba-9204080a76f6',
            'payment_type' => 'qrcredit',
            'price_object_key' => 'data.creditCardTotalSellingPrice',
            'api_standard_update_payment_status_success_url' => 'https://services.thaitravelcenter.com/flight/api/admin/payment/success',
            'api_standard_update_payment_status_fail_url' => 'https://services.thaitravelcenter.com/flight/api/admin/payment/fail',
            'created_at' => '2019-12-21 13:02:13',
            'updated_at' => '2020-01-28 09:54:57',
          ),
        )
      );
    } else {
      echo "product_internal_detail table already exist.\r\n";
    }
  }

  //
  // NOTE - Revert the changes to the database.
  // --------------------------------------------------

  public function down()
  {

    Schema::drop('payment_log');
    Schema::drop('payment_transaction');
    Schema::drop('product_internal_detail');
  }
}
