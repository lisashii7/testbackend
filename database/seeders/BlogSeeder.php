<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Blog::create([
            'uuid' => Uuid::uuid4()->toString(),
            'title' => 'Judul Blog 1',
            'description' => 'Deskripsi Blog 1',
            'image' => 'path/to/image1.jpg',
        ]);

        Blog::create([
            'uuid' => Uuid::uuid4()->toString(),
            'title' => 'Judul Blog 2',
            'description' => 'Deskripsi Blog 2',
            'image' => 'path/to/image2.jpg',
        ]);
    }
}
