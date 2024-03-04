<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidationTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validation_texts', function (Blueprint $table) {
            $table->id();
            $table->text('name')->default('the name field is required.');
            $table->text('email')->default('the email field is required.');
            $table->text('unique_email')->default('the email already exist');
            $table->text('valid_email')->default('The email must be a valid email address.');
            $table->text('password')->default('the password field is required.');
            $table->text('confirm_password')->default('confirmation password does not match');
            $table->text('minimum_password')->default('The password must be at least 6 characters.
            ');
            $table->text('phone')->default('the phone field is required.');
            $table->text('subject')->default('the subject field is required.');
            $table->text('message')->default('the message field is required.');
            $table->text('comment')->default('the comment field is required.');
            $table->text('transaction_info')->default('the transactin field is required.');
            $table->text('age')->default('the age field is required.');
            $table->text('occupation')->default('the occupation field is required.');
            $table->text('gender')->default('the gender field is required.');
            $table->text('address')->default('the address field is required.');
            $table->text('country')->default('the country field is required.');
            $table->text('city')->default('the city field is required.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('validation_texts');
    }
}
