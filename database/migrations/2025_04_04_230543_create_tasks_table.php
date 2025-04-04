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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            // Prioridad: low, medium, high.
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            // Estado: pending, in_progress, completed.
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            // Clave foránea del usuario asignado (puede ser nulo).
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            // Clave foránea del creador de la tarea.
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            // Ruta de la imagen del problema (puede ser nula).
            $table->string('image')->nullable();
            // Motivo de la tarea. Se asume un enum con valores definidos. Puedes ajustarlo según tus necesidades.
            $table->enum('reason', ['maintenance', 'failure', 'creation', 'other'])->default('other');
            // Fecha aproximada de finalización (puede ser nula).
            $table->date('approximate_completion_date')->nullable();
            // Tiempo estimado (en horas, por ejemplo).
            $table->unsignedInteger('estimated_time')->nullable();
            // Relación con la tabla projects.
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
