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
        Schema::create('my_clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->enum('is_project', [0, 1])->default(0);
            $table->enum('self_capture', [0, 1])->default(1);
            $table->string('client_prefix', 4);
            $table->string('client_logo')->default('no-image.jpg');
            $table->text('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('city')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_clients');
    }
};
