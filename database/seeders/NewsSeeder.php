<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\News;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        News::factory()->count(10)
            ->has(Comment::factory()->published()->count(5), 'comments')
            ->create();
    }
}
