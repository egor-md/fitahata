<?php

use App\Support\Microgreen\PlantCultureImporter;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        PlantCultureImporter::import('kale');
    }

    public function down(): void
    {
        PlantCultureImporter::revert('kale');
    }
};
