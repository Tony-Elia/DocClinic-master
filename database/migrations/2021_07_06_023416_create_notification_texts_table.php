<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_texts', function (Blueprint $table) {
            $table->id();
            $table->text('login_success')->default('login successfull');
            $table->text('login_credential')->default('Credentials Does not Match. Try Again');
            $table->text('inactive_user')->default('inactive user');
            $table->text('invalid_email')->default('email not found');
            $table->text('logout_success')->default('logout_success');
            $table->text('register_confirm')->default('register_confirm');
            $table->text('successfull_verification')->default('Email Verification Successfully.');
            $table->text('invalid_token')->default('invalid_token');
            $table->text('forget_password')->default('Forgot Password has been Sent to Your Email');
            $table->text('contact_message')->default('Message Send Successfully');
            $table->text('appointment_added')->default('Appointment Added');
            $table->text('appointment_removed')->default('Appointment Removed');
            $table->text('fill_up_profile')->default('Please Fill Out this Form before Appointment');
            $table->text('payment_successfull')->default('Payment Successfully');
            $table->text('payment_faild')->default('Payment Faild. Try Again');
            $table->text('account_update')->default('Account Updated Successfully');
            $table->text('password_change')->default('Password Change Successfully');
            $table->text('comment_success')->default('Comment Successfully');
            $table->text('verify_subscribe')->default('Please Check and Verify Your Email');
            $table->text('already_subscribe')->default('You have Already Subscribed');
            $table->text('successfully_subscribe')->default('Thanks For Your Subscripton');
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
        Schema::dropIfExists('notification_texts');
    }
}
