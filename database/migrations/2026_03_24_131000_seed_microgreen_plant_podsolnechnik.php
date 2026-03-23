<?php

use App\Support\Microgreen\PlantCultureImporter;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        PlantCultureImporter::import('podsolnechnik');
    }

    public function down(): void
    {
        PlantCultureImporter::revert('podsolnechnik');
    }
};
