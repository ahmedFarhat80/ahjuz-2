<?php

use App\Models\Owner;
use App\Enums\PropertyStatus;
use App\Enums\PropertyIsActive;
use App\Enums\PropertyIsSpecial;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Owner::class)->nullable()->constrained()->nullOnDelete();
            $table->string('name', 50)->unique();
            $table->string('slug')->unique();

            $table->unsignedDecimal('day_price');
            $table->unsignedDecimal('thursday_price');
            $table->unsignedDecimal('friday_price');
            $table->unsignedDecimal('insurance_price')->nullable()->default(0);
            
            $table->unsignedTinyInteger('type');
            $table->text('description');
            $table->unsignedMediumInteger('area');
            $table->unsignedTinyInteger('for');
            $table->time('opens_at');
            $table->time('closes_at');
            $table->unsignedTinyInteger('is_special')->default(PropertyIsSpecial::No)->index();
            $table->unsignedTinyInteger('is_active')->default(PropertyIsActive::No)->index();
            $table->unsignedTinyInteger('status')->default(PropertyStatus::Pending)->index();
            // $table->string('cover');
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
        Schema::dropIfExists('properties');
    }
}
