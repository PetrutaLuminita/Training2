<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Mail\Order;
use App\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;
use MongoDB\BSON\Javascript;

class ProductController extends Controller
{
    /**
     * Get products from DB not in the cart
     *
     * @return Builder[]|Collection|mixed[]
     */
    public function getProducts() {
        request('user');
        $products = Product::query()
            ->when(session()->get('cart'), function ($q, $v) {
                /** @var Builder $q */
                return $q->whereNotIn('id', $v);
            })
            ->get();

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
     * Show products added to cart
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cart()
    {
        $products = new Collection();

        if ($productIds = session()->get('cart')) {
            $products = Product::query()->whereIn('id', $productIds)->get();
        }

        return $products;
//        return view('products.cart', ['products' => $products]);
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

        return "Product $product->title was successfully added";
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

        return "Product $product->title was successfully removed";
    }

    /**
     * Check if the input for the email is correct and send the email
     *
     * @param CheckoutRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
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

        return redirect()->route('products.index');
    }
}
