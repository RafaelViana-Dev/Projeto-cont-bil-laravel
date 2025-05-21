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
        Schema::create('accountings', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('User_id'); 
            $table->string('type')->after('User_id');
    
            $table->decimal('value', 10, 2)->after('description');
            $table->date('date')->after('value');
            $table->date('competence_month')->after('date');
    
            $table->foreign('User_id')->references('id')->on('Users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accountings');
        Schema::table('accountings', function (Blueprint $table) {
            //rollback
            $table->dropForeign(['User_id']);
            $table->dropColumn([
                'User_id',
                'type',
                'value',
                'date',
                'competence_month'
            ]);
        });
    }
};
