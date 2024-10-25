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
        Schema::create('packets', function (Blueprint $table) {
            $table->id();
            $table->integer('Dst Port');
            $table->integer('Protocol');
            $table->double('Fwd Pkt Len Std');
            $table->integer('Bwd Pkt Len Min');
            $table->double('Flow Byts/s');
            $table->double('Flow IAT Std');
            $table->integer('Flow IAT Min');
            $table->integer('Fwd IAT Tot');
            $table->double('Fwd IAT Std');
            $table->double('Fwd IAT Mean');
            $table->integer('Fwd IAT Min');
            $table->integer('Bwd IAT Tot');
            $table->double('Bwd IAT Std');
            $table->integer('Bwd IAT Max');
            $table->integer('Bwd IAT Min');
            $table->integer('Fwd PSH Flags');
            $table->integer('Fwd URG Flags');
            $table->double('Fwd Pkts/s');
            $table->double('Bwd Pkts/s');
            $table->integer('Pkt Len Min');
            $table->double('Pkt Len Std');
            $table->double('Pkt Len Var');
            $table->integer('Fin Flag Cnt');
            $table->integer('Rst Flag Cnt');
            $table->integer('Psh Flag Cnt');
            $table->integer('Ack Flag Cnt');
            $table->integer('Urg Flag Cnt');
            $table->integer('Ece Flag Cnt');
            $table->integer('Down/Up Ratio');
            $table->double('Fwd Seg Size Avg');
            $table->double('Bwd Seg Size Avg');
            $table->integer('Subflow Bwd Byts');
            $table->integer('Init Fwd Win Byts');
            $table->integer('Init Bwd Win Byts');
            $table->integer('Fwd Act Data Pkts');
            $table->integer('Fwd Seg Size Min');
            $table->double('Active Std');
            $table->integer('Active Max');
            $table->integer('Active Min');
            $table->double('Idle Std');
            $table->integer('Idle Max');
            $table->integer('Idle Min');
            $table->string('Label');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packets');
    }
};
