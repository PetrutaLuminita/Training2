<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateProductRequest;
use App\Product;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class ProductAdminController extends Controller
{
    /**
     * Show all the products from the DB
     *
     * @return Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * Display the form to create a new product
     *
     * @return Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function create()
    {
        return $this->edit(new Product());
    }

    /**
     * Persist the new product in the DB
     *
     * @param ValidateProductRequest $request
     * @param Product $product
     * @return string
     */
    public function store(ValidateProductRequest $request, Product $product)
    {
        return $this->save($request, $product);
    }

    /**
     * Display a form to add/edit a product
     *
     * @param Product $product
     * @return Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function edit(Product $product)
    {
        return view('admin.edit', compact('product'));
    }

    /**
     * Update the selected product
     *
     * @param ValidateProductRequest $request
     * @param Product $product
     * @return string
     */
    public function update(ValidateProductRequest $request, Product $product)
    {
        return $this->save($request, $product);
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


    /**
     * Get all products from the database (for the ajax part)
     *
     * @return Product[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getProducts()
    {
        return Product::all();
    }

    /**
     * Get the details of the product in order to update (for the ajax part)
     *
     * @param Product $product
     * @return Product
     */
    public function getProduct(Product $product)
    {
        return $product;
    }

    /**
     * Persist the new product or the edited one
     *
     * @param ValidateProductRequest $request
     * @param Product $product
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
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

        return redirect()->route('products.index');
    }
}
