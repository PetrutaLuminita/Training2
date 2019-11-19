<?php

namespace App\Http\Controllers;

use App\Product;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
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
     * @return Factory|View
     */
    public function create()
    {
        return $this->edit();
    }

    /**
     * Persist the new product in the DB
     *
     * @param Request $request
     * @param Product $product
     * @return string
     */
    public function store(Request $request, Product $product)
    {
        return $this->save($request, $product);
    }

    /**
     * Display a form to add/edit a product
     *
     * @param Product $product
     * @return Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function edit(Product $product = null)
    {
        return view('admin.edit', compact('product'));
    }

    /**
     * Update the selected product
     *
     * @param Request $request
     * @param Product $product
     * @return string
     */
    public function update(Request $request, Product $product)
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
}
