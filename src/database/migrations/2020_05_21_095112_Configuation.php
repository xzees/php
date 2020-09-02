<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Configuation extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('configuation', function (Blueprint $table) {
      $table->increments('id')->unsigned();
      $table->string('value');
      $table->string('code');
      $table->string('brand');
      $table->timestamp('created_at')->useCurrent();
      $table->dateTime('updated_at')
        ->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
    });

    DB::table('configuation')->insert(
      [
        [
          "code" => "secret_key_secure",
          "value" => "ttcpaymentid",
          "brand" => "TVG"
        ],
        [
          "code" => "MerchantID",
          "value" => "gbp1697",
          "brand" => "TVG"
        ],
        [
          "code" => "secret_key",
          "value" => "eflO6ylyvxpw6QIrMgAAWNeykSRAVZE5",
          "brand" => "TVG"
        ],
        [
          "code" => "public_key",
          "value" => "1U9T1e4aJk1YH9O37j9XNSVZCCpqyYWH",
          "brand" => "TVG"
        ],
        [
          "code" => "token",
          "value" => "Vdd5+gm2iBkTD9l9FwdB+qUq8fZA/VVNscU2WB7Sxfh0PD8SbqS5FbDQVwdu+HZceAo6ZehhjnVqnVeIoutohEqoVN3WIqqFUkIdelN5UT02mmn8YYaxjCZwi8PWUazNarpgY3YLAp6WyLtBkFJY3O8oMpyuDAk8PeElHDevkXtLNhPS",
          "brand" => "TVG"
        ],
        [
          "code" => "brand_identifier",
          "value" => "TVG",
          "brand" => "TVG"
        ],
        [
          "code" => "link_tokens",
          "value" => "https://api.gbprimepay.com/v1/tokens",
          "brand" => "TVG",
        ],
        [
          "code" => "link_charge",
          "value" => "https://api.gbprimepay.com/v1/tokens/charge",
          "brand" => "TVG",
        ],
        [
          "code" => "link_3d_secured",
          "value" => "https://api.gbprimepay.com/v1/tokens/3d_secured",
          "brand" => "TVG",
        ],
        [
          "code" => "QrcodeQrcredit_link",
          "value" => "https://api.gbprimepay.com/gbp/gateway/",
          "brand" => "TVG",
        ],
        [
          "code" => "installment_link",
          "value" => "https://api.gbprimepay.com/v2/installment",
          "brand" => "TVG",
        ],
        [
          "code" => "void_link",
          "value" => "https://api.gbprimepay.com/v1/check_status_txn",
          "brand" => "TVG",
        ],
        [
          "code" => "BASEURL",
          "value" => "https://192.168.99.117",
          "brand" => "TVG"
        ],
        [
          "code" => "BASEFOLDER",
          "value" => "/",
          "brand" => "TVG"
        ],
        [
          "code" => "setting_link_error",
          "value" => "/th/tour/page-not-found.php",
          "brand" => "TVG"
        ],
        [
          "code" => "setting_error",
          "value" => "off",
          "brand" => "TVG"
        ],
        [
          "code" => "MAIL_HOST",
          "value" => "mx.travizgo.com",
          "brand" => "TVG"
        ],
        [
          "code" => "MAIL_PORT",
          "value" => "587",
          "brand" => "TVG"
        ],
        [
          "code" => "MAIL_USER",
          "value" => "no-reply@travizgo.com",
          "brand" => "TVG"
        ],
        [
          "code" => "MAIL_PASS",
          "value" => "ROyUKt9W*58D",
          "brand" => "TVG"
        ],
        [
          "code" => "MAIL_FROM",
          "value" => "no-reply@travizgo.com ",
          "brand" => "TVG"
        ],
        [
          "code" => "MAIL_SUBJECT",
          "value" => "การชำระเงินของคุณสำเร็จแล้ว",
          "brand" => "TVG"
        ],
        [
          "code" => "MAIL_CUSTOMER",
          "value" => "payment@travizgo.com",
          "brand" => "TVG"
        ],
      ]
    );
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('configuation');
  }
}
