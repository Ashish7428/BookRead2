<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run()
    {
        // First book
        $book1 = Book::create([
            'author_id' => 1,
            'title' => 'Malgudi Days',
            'slug' => 'malgudi-days',
            'description' => 'A collection of short stories set in the fictional town of Malgudi, showcasing everyday life in India. The stories reflect the simplicity and charm of small-town India.',
            'cover_image' => 'covers/GnGliCRtN7XgPXpcYqsjQiT5jx4FM9Xr2Npv6pls.jpg',
            'pdf_path' => 'pdfs/2FyIVR4oOWqnzy8EmTiYIHjUdewebcqC3cRKuUlA.pdf',
            'publication_year' => 1943,
            'status' => 'pending'
        ]);

        // Second book
        $book2 = Book::create([
            'author_id' => 1,
            'title' => 'Swami and Friends',
            'slug' => 'swami-and-friends',
            'description' => 'This novel follows the adventures of Swaminathan, a mischievous yet innocent schoolboy in the fictional town of Malgudi. It portrays his friendships, struggles with school, and the simple joys and challenges of childhood.',
            'cover_image' => 'covers/z7h5bC9eAD3btABElJY08b8vrRZWzNAHGD1VYmVi.jpg',
            'pdf_path' => 'pdfs/AYc7d6umy1dyKpjHW4EDqhfANoUPi4imdZy4DCwr.pdf',
            'publication_year' => 1935,
            'status' => 'pending'
        ]);

        // Attach genres
        $book1->genres()->attach([1, 4]); // Fiction and Mystery
        $book2->genres()->attach([1, 3]); // Fiction and Science Fiction
    }
}
