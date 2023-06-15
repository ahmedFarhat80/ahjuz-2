<?php

use App\Enums\CouponType;
use App\Enums\CouponStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->unsignedTinyInteger('type')->default(CouponType::Percent);
            $table->unsignedDecimal('value');
            $table->unsignedMediumInteger( 'use_count')->default(0);
            $table->unsignedMediumInteger('max_use_count')->default(0);
            $table->unsignedTinyInteger('status')->default(CouponStatus::Active)->index();
            $table->date('starts_at')->nullable();
            $table->date('ends_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
