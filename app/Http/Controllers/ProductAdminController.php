<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
     * Check if the details of the product are correct
     *
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateProduct()
    {
        return $this->validate(request(), [
            'title' => 'required',
            'price' => 'required|numeric'
        ]);
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
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function save(Request $request, Product $product)
    {
        if ($this->validateProduct()) {
            if (!isset($product)) {
                $product = new Product();
            }

            $data = $request->only([
                'title',
                'description',
                'price'
            ]);

            $product->fill($data);

            $product->save();

            if ($request->hasFile('image')) {
                $fileName = $product->getKey() . '.' . $request->file('image')->getClientOriginalExtension();
                $product->image_url = $fileName;
                $request->file('image')->storeAs('public/images', $fileName);

                $product->save();
            }

            return redirect()->route('admin.products.index');
        }
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
        $product::query()->find($product->getKey())->delete();
        
        return redirect()->route('admin.products.index');
    }

}
