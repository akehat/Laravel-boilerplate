<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsArchiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations_archive', function (Blueprint $table) {
            $table->id();
            $table->string('subdomain',100);
            $table->string('cause_name',255);
            $table->string('cause_slug',255);
            // $table->index('cause_id');
            $table->string('cause_id',100);
            $table->string('donor_first_name',100);
            $table->string('donor_last_name',100);
            $table->string('donor_email',100);
            $table->string('donor_phone',50);
            $table->string('donor_street',100);
            $table->string('donor_city',50);
            $table->string('donor_state',50)->nullable();
            $table->string('donor_zip',10)->nullable();
            $table->string('status',20);
            $table->tinyInteger('captured');
            $table->double('amount', 10, 5);
            $table->string('currency',20);
            $table->string('source',100)->nullable();
            $table->tinyInteger('anonymous');
            $table->string('additional_info',255)->nullable();
            $table->string('team',100)->nullable();  
            $table->string('affiliate',100)->nullable();
            $table->double('converted_amount', 10, 5);   
            $table->string('converted_currency',20); 
            $table->double('fee', 10, 5);
            $table->double('fee_currency', 10, 5);
            $table->double('net', 10, 5);
            $table->double('net_currency', 10, 5);
            $table->text('donor_dedication')->nullable();
            $table->string('charge_id',100); 
            $table->timestamp('archived_ts')->default(DB::raw('CURRENT_TIMESTAMP'));  
            // $table->timestamps();
            $table->timestamp('created_ts')->nullable();
            $table->timestamp('updated_ts')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donations_archive');
    }
}
