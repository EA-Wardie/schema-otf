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
        Schema::create('records', function (Blueprint $table) {
            $table->uuid()
                ->primary();

            $table->foreignUlid('collection_id')
                ->index()
                ->constrained()
                ->cascadeOnDelete();

            $table->json('data')
                ->default(json_encode([]));

            $table->boolean('published')
                ->index()
                ->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }
};
