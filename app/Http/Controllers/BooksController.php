<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;
use Spatie\Fractalistic\Fractal;
use App\Transformer\BooksTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\ApiReturnedErrors;

/**
 * @group Books management Scribe
 *
 * SCRIBE Documentation. APIs for managing Books. Aquí se puede poner todo el texto que se requiera.
 *
 * Por ejemplo, esto puede ser otro párrafo.
 *
 * Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor ... cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. ... Parte del libro 'Finibus Bonorum et Malorum' de Cicerón.
 */

class BooksController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * GET Devuelve Todos los Libros ACTIVOS.
     *
     * Se puede dejar que el sistema devuelva automáticamente la respuesta (teniendo Factory y Transformer lo hace) o realizar un json como respuesta
     *
     * @responseFile storage/docs/responses/books/getAllResponse.json
     */
    public function getBooksAll()
    {
        $books = Fractal::create()->collection(Books::all())->transformWith(BooksTransformer::class)->toArray();
        return response()->json($books);
        //return response()->json(Books::all());
    }


    /**
     * GET Devuelve los datos de un libro existente.
     *
     * @param integer $book_id Identificador del libro
     *
     * @urlParam book_id int required Identificador del libro a devolver Example:12
     *
     * @responseFile status=200 scenario="Found" storage/docs/responses/books/getBook.json

     * @responseFile status=404 scenario="Not Found" storage/docs/responses/notFound.json
     * @responseField status Status of the Response
     * @responseField error Descripción del error
     *
     */
    public function getBookById($book_id)
    {
        try {
            $data = Books::findOrFail($book_id);
            $books = Fractal::create()->item($data)->transformWith(BooksTransformer::class)->toArray();
            return response()->json($books);
        } catch (ModelNotFoundException $e) {
            return ApiReturnedErrors::returnErrorArray('NOT_FOUND');
        }
    }


    /**
     * PUT. Modificación de un libro. Debe recibir TODOS los parámetros del objeto Libro.
     *
     * @urlParam book_id int required Identificador del libro a modificar Example: 1
     * @bodyParam name string required Nombre del libro
     * @bodyParam author string required Autor del libro
     * @bodyParam pages int required Núnero de páginas del libro Example: 169
     *
     * @responseFile status=200 scenario="Modified" storage/docs/responses/books/getBook.json
     *
     * @responseFile status=422 scenario="Unprocessable Entity" storage/docs/responses/books/uniqueData.json
     *
     * @responseFile status=404 scenario="Not Found" storage/docs/responses/notFound.json
     * @responseField status Status of the Response
     * @responseField error Descripción del error
     */
    public function putBook(Request $request, $book_id)
    {

        $request->merge(['book_id' => $book_id]);
        $this->validate($request, [
            'name' => ['required', 'bail', 'string','unique:books,name,'.$book_id.',id'],
            'author' => ['required', 'bail', 'string'],
            'pages' => ['required', 'bail', 'integer', 'min:1'],
            'book_id' => ['required', 'integer', 'exists:books,id']
        ]);
        $bookObj = Books::find($book_id);
        $bookObj->name = $request->name;
        $bookObj->author = $request->author;
        $bookObj->pages = $request->pages;
        $bookObj->save();
        $bookOut = Fractal::create()->item($bookObj)->transformWith(BooksTransformer::class)->toArray();
        return response()->json($bookOut);
    }


    /**
     * PATCH. Modificación de parte de un libro. Debe recibir al menos 1 de los parámetros de entrada
     *
     * <aside class="notice">Al menos debes mandar 1 parámetro del Body 😕</aside>
     *
     * @urlParam book_id int required Identificador del libro a modificar Example: 1
     * @bodyParam name string Nombre del libro
     * @bodyParam author string Autor del libro
     * @bodyParam pages int Núnero de páginas del libro Example: 180
     *
     * @responseFile status=200 scenario="Modified" storage/docs/responses/books/getBook.json
     *
     * @responseFile status=422 scenario="Unprocessable Entity" storage/docs/responses/books/uniqueData.json
     *
     * @responseFile status=404 scenario="Not Found" storage/docs/responses/notFound.json
     * @responseField status Status of the Response
     * @responseField error Descripción del error
     *
     */
    public function patchBook(Request $request, $book_id)
    {
        // dd($request);
        //$requestCounter = count($request->all());
        //return response()->json(['counter'=>count($request->all())]);
        $request->merge(['book_id' => $book_id]);
        //dd($request->all());
        // Query parameters
        $this->validate($request, [
            // The book name
            'name' => ['required_without_all:author,pages', 'string','unique:books,name,'.$book_id.',id'],
            'author' => ['required_without_all:name,pages', 'string'],
            'pages' => ['required_without_all:author,name', 'integer', 'min:1'],
            'book_id' => ['required', 'integer', 'min:1', 'exists:books,id']
        ]);
        $bookObj = Books::find($book_id);
        if ($request->has('name')) $bookObj->name = $request->name;
        if ($request->has('author')) $bookObj->author = $request->author;
        if ($request->has('pages')) $bookObj->pages = $request->pages;
        $bookObj->save();
        $bookOut = Fractal::create()->item($bookObj)->transformWith(BooksTransformer::class)->toArray();
        return response()->json($bookOut);
    }


/**
 * DELETE. Elimina (soft delete) un libro de la colección
 *
 * @urlParam book_id int required Id del libro a eliminar Example: 3
 *
 * @responseFile storage/docs/responses/books/getAllResponse.json
 * @responseField data que contendrá la colección de los libros
 * @responseField id Identificador del libro
 * @responseField title Título del libro
 * @responseField author Autor del libro
 * @responseField pages int Número de páginas
 * @responseField created_at date Fecha de creación
 * @responseField links Objeto que contendrá los campos status y url
 * @responseField status Estado del libro
 * @responseField url Url de acceso a la informaciíon del libro
 *
 * @responseFile status=200 scenario="Removed" storage/docs/responses/books/getAllResponse.json
 *
 * @responseFile status=404 scenario="Not Found" storage/docs/responses/notFound.json
 * @responseField status Status of the Response
 * @responseField error Descripción del error
 */
    public function deleteBook($book_id)
    {
        try {
            $data = Books::findOrFail($book_id)->delete();


            return $this->getBooksAll();
        } catch (ModelNotFoundException $e) {
            return ApiReturnedErrors::returnErrorArray('NOT_FOUND');
        }
    }

    /**
     * POST. Crea un libro y lo introduce si es correcto en la colección
     *
     * @bodyParam name string required Nombre o título del libro. Debe ser único en todo el sistema. Example: Libro de Pruebas
     * @bodyParam author string required Autor del libro. Example: Paul Bettenan
     * @bodyParam pages int required Número de páginas del libro
     *
     * @responseFile status=200 storage/docs/responses/books/getBook.json
     *
     * @responseFile status=422 scenario="Unprocessable Entity" storage/docs/responses/books/uniqueData.json
     * @responseField name campo contiene los errores generados. en este caso, el campo name debe ser únic, Pueden existir tantos campos como errores generados, donde la clave es el campo de entrada con error
     */
    public function postBook(Request $request) {
        $this->validate($request, [
            'name' => ['required', 'bail', 'string','unique:books'],
            'author' => ['required', 'bail', 'string'],
            'pages' => ['required', 'bail', 'integer', 'min:1']
        ]);
        $book = Books::create($request->all());
        $bookOut = Fractal::create()->item($book)->transformWith(BooksTransformer::class)->toArray();
        return response()->json($bookOut);
    }

    //
}
