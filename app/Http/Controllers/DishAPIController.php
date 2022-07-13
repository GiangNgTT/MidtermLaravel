<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class DishAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $dishs = Dish::join('categories', 'categories.id', 'dishes.category_id')
            ->select('categories.cate_name as name_ctgs', 'dishes.*')
            ->paginate(20);
        if ($dishs) {
            return response()->json($dishs, Response::HTTP_OK);
        } else {
            return response()->json([]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validation = Validator::make(
            $request->all(),
            [
                "nameFood" => "required",
                "description"  => "required",
                "price"  => "required|number",
                'image' => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]
        );

        if ($validation->fails()) {
            $response = array('status' => 'error', 'errors' => $validation->errors()->toArray());
            return response()->json($response);
        }

        $name = '';

        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('images');
            $file->move($destinationPath, $name);
        }

        $dish = new Dish();
        $dish->nameFood = $request->input('nameFood');
        $dish->description = $request->input('description');
        $dish->category_id = $request->category_id;
        $dish->price = $request->input('price');
        $dish->image = $name;
        $dish->save();
        if ($dish) {
            return response()->json(["status" => "successful", "success" => true, "message" => "dish record created successfully", "data" => $dish]);
        } else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! failed to create."]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $name = '';

        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('images');
            $file->move($destinationPath, $name);
        }

        $dish = Dish::find($id);;
        $dish->nameFood = $request->input('nameFood');
        $dish->description = $request->input('description');
        $dish->category_id = $request->category_id;
        $dish->price = $request->input('price');
        $dish->image = $name;
        $dish->save();
        if ($dish) {
            return response()->json(["status" => "successful", "success" => true, "message" => "dish record created successfully", "data" => $dish]);
        } else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! failed to create."]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
           $dish = Dish::find($id);
           $linkImage = public_path('images/') . $dish->image;
           if (File::exists($linkImage)) {
               File::delete($linkImage);
           }
           $dish->delete();
    }
    public function search(Request $request)
    {
        $dishes = Dish::join('categories', 'categories.id', 'dishes.category_id')
            ->where('nameFood', 'like', '%' . $request->search . '%')
            ->select('categories.cate_name as name_ctgs', 'dishes.*')
            ->get();
        return response()->json($dishes, Response::HTTP_OK);
    }
}
