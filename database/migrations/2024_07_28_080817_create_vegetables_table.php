<?php
// database/migrations/xxxx_xx_xx_create_vegetables_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVegetablesTable extends Migration
{
    public function up()
    {
        Schema::create('vegetables', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 8, 2);
            $table->string('image');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vegetables');
    }
}
