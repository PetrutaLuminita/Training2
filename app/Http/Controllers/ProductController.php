<?php

namespace App\Http\Controllers;

use App\Mail\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Get products from DB not in the cart
     *
     * @return Builder[]|Collection|mixed[]
     */
    public function getProducts()
    {
        $products = Product::query()
            ->when(session()->get('cart'), function ($q, $v) {
                /** @var Builder $q */
                return $q->whereNotIn('id', $v);
            })
            ->get();

        return $products;
    }

    /**
     * Show products added to cart
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCart()
    {
        $products = new Collection();

        if ($productIds = session()->get('cart')) {
            $products = Product::query()->whereIn('id', $productIds)->get();
        }

        return $products;
    }

    /**
     * Show products that are not in the cart
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('products.index');
    }

    /**
     * Show the cart page with the checkout form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cart()
    {
        $products = new Collection();

        if ($productIds = session()->get('cart')) {
            $products = Product::query()->whereIn('id', $productIds)->get();
        }

        return view('products.cart');
    }

    /**
     * Add the id of the project in the session
     *
     * @param Product $product
     * @return string
     */
    public function addToCart(Product $product)
    {
        $key = $product->getKey();

        if (!session('cart') || !in_array($key, session('cart'))) {
            session()->push('cart', $key);
        }

        return __('Product') . ' ' . $product->title . ' ' . __('was successfully added');
    }

    /**
     * Remove the id of the product from the session
     *
     * @param Product $product
     * @return string
     */
    public function removeFromCart(Product $product)
    {
        $id = $product->getKey();

        if (session('cart') && in_array($id, session('cart'))) {
            $pos = array_search($id, session('cart'));
            session()->forget('cart.' . $pos);
        }

        return __('Product') . ' ' . $product->title . ' ' . __('was successfully removed');
    }

    /**
     * Check if the input for the email is correct and send the email
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'comments' => 'nullable'
        ]);

        $products = Product::query()->whereIn('id', session('cart'))->get();

        if ($validator->passes()) {
            Mail::to(config('app.manager_email'))->send(new Order(
                $products,
                $request->get('name'),
                $request->get('email'),
                $request->get('comments')
            ));

            session()->forget('cart');

            return response()->json(['success' => 'Success!']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }
}
