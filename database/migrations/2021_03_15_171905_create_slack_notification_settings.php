<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscordNotificationSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slack_notification_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')
                ->unique()
                ->constrained('services')
                ->onDelete('cascade');
            $table->string('webhook_url');
            $table->boolean('enabled')->default(true);
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
        Schema::dropIfExists('slack_notification_settings');
    }
}