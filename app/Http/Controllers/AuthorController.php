<?php

namespace App\Http\Controllers;

use App\Author;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    use ApiResponser;
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
     * Return the list of Author
     *
     * @return Response
     */
    public function index()
    {
        $authors = Author::all();
        return $this->successResponse($authors);

    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'gender' => 'required|max:255|in:male,female',
            'country' => 'required|max:255',
        ];

        $this->validate($request, $rules);

        $author = Author::create($request->all());
        return $this->successResponse($author, Response::HTTP_CREATED);

    }

    public function show($author)
    {
        $author = Author::findOrFail($author);
        return $this->successResponse($author, Response::HTTP_OK);


    }

    public function update(Request $request, $author)
    {

        $rules = [
            'name' => 'max:255',
            'gender' => 'max:255|in:male,female',
            'country' => 'max:255',
        ];

        $this->validate($request, $rules);

        $authorm = Author::findOrFail($author);

        $authorm->fill($request->all());

        if($authorm->isClean())
        {
            return $this->errorResponse('at least one value must be changed', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $authorm->save();

        return $this->successResponse($authorm, Response::HTTP_OK);

    }

    public function destroy($author)
    {
        $authorm = Author::findOrFail($author);

        $authorm->delete();

        return $this->successResponse($authorm, Response::HTTP_OK);

    }

    //
}
