<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Recipe;
use Cloudinary\Cloudinary;

class MigrateImagesToCloudinary extends Command
{
    protected $signature = 'images:migrate';
    protected $description = 'Migrate local images to Cloudinary';

    public function handle() {
        $recipes = Recipe::all();

        foreach ($recipes as $recipe) {
            try {
                $localPath = storage_path('app/public/' . $recipe->image);
                
                if (file_exists($localPath)) {
                    

                    $cloudinary = new Cloudinary([
                        'cloud' => [
                            'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                            'api_key' => env('CLOUDINARY_API_KEY'),
                            'api_secret' => env('CLOUDINARY_API_SECRET'),
                        ]
                    ]);

    $result = $cloudinary->uploadApi()->upload($localPath);
    $recipe->update(['image' => $result['secure_url']]);
                    } else {
                    $this->warn("⚠️ File not found: {$recipe->recipe_name}");
                }


            } catch (\Exception $e) {
                $this->error("❌ Failed: {$recipe->recipe_name} - {$e->getMessage()}");
            }
        }

        $this->info('Migration complete!');
    }
}