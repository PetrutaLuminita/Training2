<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateProductRequest;
use App\Product;

class ProductAdminController extends Controller
{
    /**
     * Show all the products from the DB
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index()
    {
        $products = Product::all();

        return view('admin.index', ['products' => $products]);
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


    /**
     * Persist the new product or the edited one
     *
     * @param ValidateProductRequest $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(ValidateProductRequest $request, Product $product)
    {
        $validData = $request->validated();

        $product->fill($validData);
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

        return redirect()->route('admin.products.index');
    }

    /**
     * Delete the selected product
     *
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        $product->delete();
        
        return redirect()->route('admin.products.index');
    }

}
