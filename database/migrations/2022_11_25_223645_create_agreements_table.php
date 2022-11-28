<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45);
            $table->string('city', 45);
            $table->foreignId('agreement_type_id')->constrained();
            $table->enum('status', ['vigente', 'en renovacion', 'vencido']);
            $table->text('information');
            $table->text('contact_info');
            $table->foreignId('program_id')->constrained();
            $table->foreignId('university_id')->constrained();
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
        Schema::dropIfExists('agreements');
    }
}
