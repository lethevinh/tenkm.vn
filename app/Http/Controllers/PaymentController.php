<?php


namespace App\Http\Controllers;


use App\Models\Course;
use App\Models\Event;
use App\Models\Order;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Omnipay\Payoo\Payoo;

class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function order(Course $course)
    {
        $user = request()->user();
        try {
            $order = $course->orders()->create([
                'amount' => $course->price_fl,
                'user_id' => $user->id,
            ]);
            if ($order) {
                return redirect(route('order.checkout', $order->transaction_id));
            }
        }catch (\Exception $exception) {
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function form($order_id)
    {
        $order = $this->_getOrder($order_id);

        return view('pages.checkout', compact('order'));
    }

    public function checkout($gateway, $order_id)
    {
        // $order = Order::findOrFail(decrypt($order_id));
        $order = $this->_getOrder(decrypt($order_id));
        $user = $order->user;
        $payoo = new Payoo();
        $description = "Order No: [$order->transaction_id].</br>Product info, travel info or service info...(ex: )</br>Money total: ".$payoo->formatAmount($order->amount);
        $response = $payoo->purchase([
            'amount' => $payoo->formatAmount($order->amount),
            'transactionId' => $order->transaction_id,
            'currency' => 'VND',
            'cancelUrl' => $payoo->getCancelUrl($order),
            'returnUrl' => $payoo->getReturnUrl($order),
            'notifyUrl' => $payoo->getNotifyUrl($order),
            // 'testMode' => config('app.env') === 'local',
            'testMode' => true,
            'card' => [
                'billingFirstName' => $user->name,
                'billingLastName' => 'Vinh',
                'billingAddress2' => '35 Nguyen Hue, Phuong Ben Nghe, Quan 1, Tp Ho Chi Minh',
                'phone' => $user->phone,
                'city' => '24000',
                'email' => $user->email,
                'number' => $user->phone
            ],
            'description' => $description
        ]);

        if ($response->isRedirect()) {
            $response->redirect();
        }

        return redirect()->back()->with([
            'message' => $response->getMessage(),
        ]);
    }

    public function completed($gateway, $order_id)
    {
        $order = $this->_getOrder($order_id);

        $payoo = new Payoo();

        $response = $payoo->complete([
            'amount' => $payoo->formatAmount($order->amount),
            'transactionId' => $order->transaction_id,
            'currency' => 'USD',
            'cancelUrl' => $payoo->getCancelUrl($order),
            'returnUrl' => $payoo->getReturnUrl($order),
            'notifyUrl' => $payoo->getNotifyUrl($order),
        ]);

        if ($response->isSuccessful()) {
            $order->update([
                'payment_status' => Order::PAYMENT_COMPLETED,
            ]);
            $student = Student::find($order->user->id);
            if ($student->type_lb != 'teacher') {
                $student->update([
                    'type_lb' => 'student'
                ]);
            }
            $student->registerCourse($order->course);

            return redirect()->route('order.checkout', $order_id)->with([
                'message' => 'You recent payment is successful with reference code ' . $response->getTransactionReference(),
            ]);
        }
        return redirect()->back()->with([
            'message' => $response->getMessage(),
        ]);
    }

    public function cancelled($gateway, $order_id)
    {
        $order = $this->_getOrder($order_id);

        return redirect()->route('order.checkout', $order_id)->with([
            'message' => 'You have cancelled your recent PayPal payment !',
        ]);
    }

    public function webhook($order_id, $env)
    {
        // to do with new release of sudiptpa/paypal-ipn v3.0 (under development)
    }

    protected function _getOrder($order_id){
        return Order::where('transaction_id', $order_id)
            ->where('user_id', request()->user()->id)
            ->firstOrFail();
    }

}
