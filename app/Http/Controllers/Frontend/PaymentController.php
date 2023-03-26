<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function notification(Request $request)
	{
		$payload = $request->getContent();
		$notification = json_decode($payload);

		$validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . config('midtrans.serverKey'));

		if ($notification->signature_key != $validSignatureKey) {
			return response(['message' => 'Invalid signature'], 403);
		}

		$this->initPaymentGateway();
		$statusCode = null;

		$paymentNotification = new \Midtrans\Notification();
		$order = Order::where('code', $paymentNotification->order_id)->firstOrFail();

		if ($order->isPaid()) {
			return response(['message' => 'The order has been paid before'], 422);
		}

		$transaction = $paymentNotification->transaction_status;
		$type = $paymentNotification->payment_type;
		$orderId = $paymentNotification->order_id;
		$fraud = $paymentNotification->fraud_status;

		$vaNumber = null;
		$vendorName = null;
		if (!empty($paymentNotification->va_numbers[0])) {
			$vaNumber = $paymentNotification->va_numbers[0]->va_number;
			$vendorName = $paymentNotification->va_numbers[0]->bank;
		}

		$paymentStatus = null;
		if ($transaction == 'capture') {
			// For credit card transaction, we need to check whether transaction is challenge by FDS or not
			if ($type == 'credit_card') {
				if ($fraud == 'challenge') {
					// TODO set payment status in merchant's database to 'Challenge by FDS'
					// TODO merchant should decide whether this transaction is authorized or not in MAP
					$paymentStatus = Payment::CHALLENGE;
				} else {
					// TODO set payment status in merchant's database to 'Success'
					$paymentStatus = Payment::SUCCESS;
				}
			}
		} else if ($transaction == 'settlement') {
			// TODO set payment status in merchant's database to 'Settlement'
			$paymentStatus = Payment::SETTLEMENT;
		} else if ($transaction == 'pending') {
			// TODO set payment status in merchant's database to 'Pending'
			$paymentStatus = Payment::PENDING;
		} else if ($transaction == 'deny') {
			// TODO set payment status in merchant's database to 'Denied'
			$paymentStatus = PAYMENT::DENY;
		} else if ($transaction == 'expire') {
			// TODO set payment status in merchant's database to 'expire'
			$paymentStatus = PAYMENT::EXPIRE;
		} else if ($transaction == 'cancel') {
			// TODO set payment status in merchant's database to 'Denied'
			$paymentStatus = PAYMENT::CANCEL;
		}

		$paymentParams = [
			'order_id' => $order->id,
			'number' => Payment::generateCode(),
			'amount' => $paymentNotification->gross_amount,
			'method' => 'midtrans',
			'status' => $paymentStatus,
			'token' => $paymentNotification->transaction_id,
			'payloads' => $payload,
			'payment_type' => $paymentNotification->payment_type,
			'va_number' => $vaNumber,
			'vendor_name' => $vendorName,
			'biller_code' => $paymentNotification->biller_code,
			'bill_key' => $paymentNotification->bill_key,
		];

		$payment = Payment::create($paymentParams);

		if ($paymentStatus && $payment) {
			\DB::transaction(
				function () use ($order, $payment) {
					if (in_array($payment->status, [Payment::SUCCESS, Payment::SETTLEMENT])) {
						$order->payment_status = Order::PAID;
						$order->status = Order::CONFIRMED;
						$order->save();
					}
				}
			);
		}

		$message = 'Payment status is : '. $paymentStatus;

		$response = [
			'code' => 200,
			'message' => $message,
		];

		return response($response, 200);
	}

	/**
	 * Show completed payment status
	 *
	 * @param Request $request payment data
	 *
	 * @return void
	 */
	public function completed(Request $request)
	{
		$code = $request->query('order_id');
		$order = Order::where('code', $code)->firstOrFail();
		
		if ($order->payment_status == Order::UNPAID) {
			return redirect('payments/failed?order_id='. $code);
		}

		// \Session::flash('success', "Thank you for completing the payment process!");

		return redirect('orders/received/'. $order->id);
	}

	/**
	 * Show unfinish payment page
	 *
	 * @param Request $request payment data
	 *
	 * @return void
	 */
	public function unfinish(Request $request)
	{
		$code = $request->query('order_id');
		$order = Order::where('code', $code)->firstOrFail();

		// \Session::flash('error', "Sorry, we couldn't process your payment.");

		return redirect('orders/received/'. $order->id);
	}

	/**
	 * Show failed payment page
	 *
	 * @param Request $request payment data
	 *
	 * @return void
	 */
	public function failed(Request $request)
	{
		$code = $request->query('order_id');
		$order = Order::where('code', $code)->firstOrFail();

		// \Session::flash('error', "Sorry, we couldn't process your payment.");

		return redirect('orders/received/'. $order->id);
	}
}
