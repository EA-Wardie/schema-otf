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
        Schema::create('collections', function (Blueprint $table) {
            $table->uuid('id')
                ->primary();

            $table->string('name');

            $table->string('slug')
                ->index()
                ->unique();

            $table->json('schema')
                ->default(json_encode([]));

            $table->boolean('published')
                ->index()
                ->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }
};
