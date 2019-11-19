<?php

namespace App\Http\Controllers;

use App\Product;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProductAdminController extends Controller
{
    /**
     * Get all products from the database (for the ajax part)
     *
     * @return Product[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllProducts()
    {
        $products = Product::all();

        return $products;
    }

    /**
     * Show all the products from the DB
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index()
    {
        $products = Product::all();

        return view('admin.index');
    }

    /**
     * Display a form to add/edit a product
     *
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit(Product $product)
    {
        return view('admin.edit', ['product' => $product]);
    }

    public function getProductForEdit(Product $product)
    {
        return $product;
    }

    /**
     * Persist the new product or the edited one
     *
     * @param Request $request
     * @param Product $product
     * @return string
     */
    public function save(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'image' => 'nullable',
        ]);

        if ($validator->passes()) {
            if (!$product) {
                $product = new Product();
            }

            $product->title = $request->get('title');
            $product->description = $request->get('description');
            $product->price = $request->get('price');

            $product->save();

            if ($request->hasFile('image')) {
                $fileName = $product->getKey() . '.' . $request->file('image')->getClientOriginalExtension();

                // save image in storage
                if ($request->file('image')->storeAs('public/images', $fileName)) {
                    // save product image
                    $product->image_path = $fileName;
                    $product->save();
                }
            }
            return response()->json(['success'=>'Success!']);
        } else {
            return response()->json(['error'=>$validator->errors()->all()]);
        }
    }

    /**
     * Delete the selected product
     *
     * @param Product $product
     * @return string
     * @throws Exception
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return 'Product deleted';
    }

}
