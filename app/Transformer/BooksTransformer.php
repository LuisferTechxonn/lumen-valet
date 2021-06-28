<?php

namespace App\Transformer;

use App\Models\Books;

use League\Fractal\TransformerAbstract;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class BooksTransformer extends TransformerAbstract {

    public function transform(Books $book) {
        return [
            'id' => (int)$book->id,
            'title' => trim($book->name),
            'author' => trim($book->author),
            'pages' => (int)$book->pages,
            //'created_at' => $book->created_at,
            'created_at' => Str::substr($book->created_at,0,10),
            'links' => [
                'status' => 'created',
                'url' => '/api/books/'.(int)$book->id
            ]
        ];
    }

}
