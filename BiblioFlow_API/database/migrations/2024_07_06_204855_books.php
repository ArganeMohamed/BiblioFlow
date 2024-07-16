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
        schema::create("books" , function(Blueprint $t) {
            $t->id();
            $t->string("title");
            $t->unsignedInteger("author_id");
            $t->unsignedInteger("genre_id");
            $t->unsignedInteger("langue_id");
            $t->date('publication_date');
            $t->string("isbn");
            $t->string("nbr_pages");
            $t->text("description");
            $t->string("image");
            $t->timestamps();
        
            $t->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
            $t->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');
            $t->foreign('langue_id')->references('id')->on('langues')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }

};




/**
* Reverse the migrations.
*/



