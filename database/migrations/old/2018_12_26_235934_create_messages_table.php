<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location_id');
            $table->enum('type', ['CHAR_PUB', 'CHAR_PRIV', 'SYS_PUB', 'SYS_PRIV']);
            $table->integer('character_id')->nullable(true);
            $table->integer('listener_id')->nullable(true);
            $table->text('text');
            $table->timestamp('added_on')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
