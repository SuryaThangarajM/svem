<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expensedetails', function (Blueprint $table) {
            $table->id();
            $table->date('BillDate');
            $table->string('oprvehiid', 100); // instead of text
            $table->string('head', 100);     // instead of text
            $table->double('ExpAmt');
            $table->timestamps();
            $table->unique(['oprvehiid', 'head', 'BillDate']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expensedetails');
    }
};
