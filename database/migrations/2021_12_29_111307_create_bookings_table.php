<?php

use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Property;
use App\Enums\BookingStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Property::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Customer::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Coupon::class)->nullable()->constrained()->nullOnDelete();

            $table->unsignedTinyInteger('payment_method')->nullable();

            // subtotal_price = unit_price * number of days
            // total_price = subtotal_price + insurance - discount
            // revenue = total_price - commission

            // $table->unsignedDecimal('unit_price')->nullable();
            $table->unsignedDecimal('subtotal_price')->nullable();
            $table->unsignedDecimal('insurance')->nullable();
            $table->unsignedDecimal('discount')->nullable();
            $table->unsignedDecimal('total_price')->nullable();
            $table->unsignedDecimal('commission')->nullable();
            $table->unsignedDecimal('revenue')->nullable();

            $table->boolean('is_foreign')->default(0);
            $table->string('details')->nullable();
            $table->unsignedTinyInteger('status')->default(BookingStatus::Paid)->index();
            $table->date('starts_at')->index();
            $table->date('ends_at')->index();
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
        Schema::dropIfExists('bookings');
    }
}
