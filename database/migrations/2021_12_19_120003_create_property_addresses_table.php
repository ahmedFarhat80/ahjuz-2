<?php

use App\Models\Governorate;
use App\Models\Property;
use App\Models\Region;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Property::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Governorate::class)->constrained();
            $table->foreignIdFor(Region::class)->constrained();
            $table->string('details', 100);
            $table->double('longitude')->default(0);
            $table->double('latitude')->default(0);
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
        Schema::dropIfExists('property_addresses');
    }
}
