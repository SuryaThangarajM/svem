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
        Schema::create('billdetails', function (Blueprint $table) {
            $table->id();
            $table->Integer('BillNo')->unique(); // Store a unique BillNo (can use bigInteger if needed)
            $table->date('BillDate'); // Stores the date in YYYY-MM-DD format
            $table->string('CusName');
            $table->string('CusMobNo');
            $table->text('CusAddress');
            $table->string('OprName');
            $table->string('VehiID');
            $table->text('Works')->nullable();
            $table->float('StartTime', 8, 2);
            $table->float('EndTime', 8, 2);
            $table->float('TotalTime', 8, 2);
            $table->double('TotalAmount');
            $table->double('Paid')->nullable();
            $table->double('Balance');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billdetails');
    }
};
