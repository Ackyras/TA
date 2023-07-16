<?php

use App\Models\Unit;
use App\Models\Period;
use App\Models\Division;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name');
            $table->foreignId('parent_id')->nullable()->constrained('programs')->onDelete('cascade');
            $table->foreignIdFor(Division::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Period::class)->constrained()->cascadeOnDelete();
            $table->boolean('is_parent')->default(false);
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
        Schema::dropIfExists('programs');
    }
};
