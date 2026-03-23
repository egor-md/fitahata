<?php

use App\Support\Microgreen\PlantCultureImporter;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        PlantCultureImporter::import('luk');
    }

    public function down(): void
    {
        PlantCultureImporter::revert('luk');
    }
};
