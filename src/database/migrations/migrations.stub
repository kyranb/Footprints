<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFootprintsTable extends Migration
{

    private function getConnectionName()
    {
        return config('footprints.connection_name') ? config('footprints.connection_name') : config('database.default');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->getConnectionName())->create(config('footprints.table_name'), function (Blueprint $table) {
            
            $table->increments('id');
            $table->integer(config('footprints.column_name'))->unsigned()->nullable();
            $table->string('cookie_token');
            $table->string('landing_domain');
            $table->string('landing_page');
            $table->string('landing_params')->nullable();
            $table->string('referrer_domain')->nullable();
            $table->string('referrer_url')->nullable();
            $table->string('referrer')->nullable();
            $table->string('utm_source')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_term')->nullable();
            $table->string('utm_content')->nullable();
            $table->string('referral')->nullable();
            
            if (config('footprints.custom_parameters')) {
                foreach (config('footprints.custom_parameters') as $parameter) {
                    $table->string($parameter)->nullable();
                }
            }
            
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
        Schema::connection($this->getConnectionName())->drop(config('footprints.table_name'));
    }
}
