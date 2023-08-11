<?php

use App\Models\Program;
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
        Schema::create('proposal_dictionaries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(Division::class)->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->constrained('programs')->cascadeOnDelete();
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
        Schema::dropIfExists('proposal_dictionaries');
    }
};
