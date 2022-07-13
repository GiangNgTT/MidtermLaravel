<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Dish;
use Illuminate\Http\Request;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $dishes  = Dish::all();
        return view('viewDishes', ['dishes'=> $dishes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('addDish', ['categories'=>Category::all()]); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        //
        $name = '';
        
        if($req -> hasFile('image')){
            $this->validate($req,[
                'image' =>'mimes:jpg,png,jpeg|max:2048',
            ],[
                'image.mimes'=>'Chỉ chấp nhận files ảnh',
                'image.max' => 'Chỉ chấp nhận files ảnh dưới 2Mb',

            ]);
            $file =$req ->file(('image'));
            $name = time().'_'.$file->getClientOriginalName();
            $destinationPath=public_path('images');
            $file -> move($destinationPath, $name);
        }
        $this->validate($req,[
            'nameFood'=>'required',
            'description'=>'required', 
            'price'=>'required',        
        ],[
            'nameFood.required' =>'Bạn chưa nhập nameFood',
            'description.required' =>'Bạn chưa nhập mô tả',
            'price.required' =>'Bạn chưa nhập price',           
            
        ]);
        $dish=new Dish();
        $dish->nameFood=$req->nameFood;
        $dish->description=$req->description;
        $dish->price=$req->price;
        $dish->category_id=$req->category_id;
        $dish->image=$name;
        $dish->save();

        return redirect()->route('dishes.index')->with('success', 'Bạn đã thêm mới thành công');
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
    }
}
