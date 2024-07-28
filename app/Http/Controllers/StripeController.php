<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Vegetable;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class StripeController extends Controller
{
    public function handlePayment(Request $request)
    {
        \Log::info('Handling payment', $request->all());

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $amount = $request->amount * 100; // amount in cents

            $charge = Charge::create([
                'amount' => $amount,
                'currency' => 'inr',
                'description' => 'Payment for vegetable',
                'source' => $request->stripeToken,
                'receipt_email' => $request->email,
            ]);

            \Log::info('Charge created successfully', $charge->toArray());

            // Store payment details in the database
            $payment = new Payment();
            $payment->email = $request->email;
            $payment->stripe_id = $charge->id;
            $payment->amount = $request->amount;
            $payment->currency = 'inr';
            $payment->save();

            \Log::info('Payment saved successfully', $payment->toArray());

            return redirect()->route('payment.confirmation')->with('success_message', 'Payment successful!');
        } catch (\Exception $ex) {
            \Log::error('Payment failed', ['error' => $ex->getMessage()]);
            return back()->with('error_message', $ex->getMessage());
        }
    }

    public function index()
    {
        $vegetables = Vegetable::all();
        return view('shop', compact('vegetables'));
    }

    public function create()
    {
        return view('add-vegetable');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        Vegetable::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $imageName,
        ]);

        return redirect()->route('shop')->with('success', 'Vegetable added successfully.');
    }

    public function checkout($id)
    {
        $vegetable = Vegetable::findOrFail($id);
        return view('checkout', compact('vegetable'));
    }

    public function paymentConfirmation()
    {
        return view('payment-confirmation');
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'stripeToken' => 'required',
            'vegetable_id' => 'required|exists:vegetables,id',
        ]);

        $vegetable = Vegetable::findOrFail($request->vegetable_id);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $charge = Charge::create([
                'amount' => $vegetable->price * 100, // amount in cents
                'currency' => 'inr',
                'description' => 'Payment for ' . $vegetable->name,
                'source' => $request->stripeToken,
                'receipt_email' => $request->email,
            ]);

            // Store payment details in the database
            Payment::create([
                'email' => $request->email,
                'stripe_id' => $charge->id,
                'amount' => $vegetable->price,
                'currency' => 'inr',
            ]);

            return redirect()->route('shop')->with('success_message', 'Payment successful!');
        } catch (\Exception $e) {
            return back()->with('error_message', $e->getMessage());
        }
    }

    public function showPaymentPage(Request $request)
    {
        $amount = $request->price;
        $vegetableName = $request->name;
    
        // Fetch the payments from the database
        $payments = Payment::all();
    
        return view('payments', compact('amount', 'vegetableName', 'payments'));
    }
    

}
