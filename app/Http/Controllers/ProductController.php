<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function index() {

        $products = Product::latest()->get();

        return response()->json([
            'products' => $products
        ], Response::HTTP_OK);
    }

    public function store(Request $request) {

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;

        if ($request->photo != "") {

            $strpos = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time().'.'.$ex;
            $img = Image::read($request->photo)->resize(200, 200);
            $uploadPath = public_path()."/upload/";
            $img->save($uploadPath.$name);
            $product->photo = $name;
        } else {
            $product->photo = '1.jpg';
        }

        $product->photo = $name;
        $product->type = $request->type;
        $product->quantity = $request->quantity;
        if ($request->item_code == "") {
            $product->item_code = Str::random(8);
        }
        $product->unit_price = $request->price;
        $product->save();

        return response()->json([
            'product' => $product
        ], Response::HTTP_CREATED);

    }

    public function update(Request $request, $id) {

        $product = Product::find($id);

        $product->name = $request->name;
        $product->description = $request->description;

        if ($product->photo != $request->photo) {

            $strpos = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time().'.'.$ex;
            $img = Image::read($request->photo)->resize(200, 200);
            $uploadPath = public_path()."/upload/";
            $image = $uploadPath.$product->photo;
            $img->save($uploadPath.$name);
            if (file_exists($image)) {
                @unlink($image);
            }
            // $product->photo = $name;
        } else {
            $name = $product->photo;
        }

        $product->photo = $name;
        $product->type = $request->type;
        $product->quantity = $request->quantity;
        if ($request->item_code == "") {
            $product->item_code = Str::random(8);
        }
        $product->unit_price = $request->price;
        $product->save();

        return response()->json([
            'product' => $product
        ], Response::HTTP_OK);
    }

    public function edit($id) {

        $product = Product::find($id);

        return response()->json([
            'product' => $product
        ], Response::HTTP_OK);
    }

    public function destroy($id) {

        $product = Product::find($id);

        $imagePath = public_path()."/upload/";
        $image = $imagePath.$product->photo;

        if (file_exists($image)) {
            @unlink($image);
        }

        $product->delete();

        return response()->json([
            'message' => 'Destroy Product'
        ], Response::HTTP_NO_CONTENT);

    }
}
