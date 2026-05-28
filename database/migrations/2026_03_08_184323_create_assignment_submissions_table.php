<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('assignment_id')
                ->constrained('assignments')
                ->cascadeOnDelete();

            $table->foreignId('student_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->text('submission_text')->nullable();
            $table->string('file')->nullable();
            $table->integer('grade')->nullable();
            $table->text('feedback')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assignment_submissions');
    }

}
