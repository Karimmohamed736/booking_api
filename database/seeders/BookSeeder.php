<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::create([
            'title' => 'Book1',
            'price' => 500,
            'desc' => 'this is book1'
        ]);
        Book::create([
            'title' => 'Book2',
            'price' => 600,
            'desc' => 'this is book2'
        ]);
    }
}
