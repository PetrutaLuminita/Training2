<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Mail\Order;
use App\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;

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

        return __('Product added', ['product' => $product->title]);
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

        return __('Product removed', ['product' => $product->title]);
    }

    /**
     * Check if the input for the email is correct and send the email
     *
     * @param CheckoutRequest $request
     * @return array
     */
    public function checkout(CheckoutRequest $request)
    {
        $validData = $request->validated();
        $products = Product::query()->whereIn('id', session('cart'))->get();

        Mail::to(config('app.manager_email'))->send(new Order(
            $products,
            $validData['name'],
            $validData['email'],
            $validData['comments']
        ));
        session()->forget('cart');

        return ['success' => true, 'message' => __('Success')];
    }
}
