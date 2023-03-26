<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\ProductInventory;
use App\Http\Controllers\Controller;
use App\Exceptions\OutOfStockException;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $statuses = Order::STATUSES;
        $orders = Order::latest();

        $q = $request->input('q');
		if ($q) {
			$orders = $orders->where('code', 'like', '%'. $q .'%')
				->orWhere('customer_first_name', 'like', '%'. $q .'%')
				->orWhere('customer_last_name', 'like', '%'. $q .'%');
		}


		if ($request->input('status') && in_array($request->input('status'), array_keys(Order::STATUSES))) {
			$orders = $orders->where('status', '=', $request->input('status'));
		}

		$startDate = $request->input('start');
		$endDate = $request->input('end');

		if ($startDate && !$endDate) {
			\Session::flash('error', 'The end date is required if the start date is present');
			return redirect('admin/orders');
		}

		if (!$startDate && $endDate) {
			\Session::flash('error', 'The start date is required if the end date is present');
			return redirect('admin/orders');
		}

		if ($startDate && $endDate) {
			if (strtotime($endDate) < strtotime($startDate)) {
				\Session::flash('error', 'The end date should be greater or equal than start date');
				return redirect('admin/orders');
			}

			$order = $orders->whereRaw("DATE(order_date) >= ?", $startDate)
				->whereRaw("DATE(order_date) <= ? ", $endDate);
        }
        
        $orders = $orders->get();;

		return view('admin.orders.index', compact('orders','statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
	{
		$order = Order::withTrashed()->findOrFail($id);

		return view('admin.orders.show', compact('order'));
	}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
		//
		dd('ok');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
	{
		$order = Order::withTrashed()->findOrFail($id);
		
		if ($order->trashed()) {
			$canDestroy = \DB::transaction(
				function () use ($order) {
					OrderItem::where('order_id', $order->id)->delete();
					$order->shipment->delete();
					$order->forceDelete();

					return true;
				}
			);
			return redirect('admin/orders/trashed');
		} else {
			$canDestroy = \DB::transaction(
				function () use ($order) {
					if (!$order->isCancelled()) {
						foreach ($order->orderItems as $item) {
							ProductInventory::increaseStock($item->product_id, $item->qty);
						}
					};

					$order->delete();

					return true;
				}
			);

			return redirect('admin/orders');
		}
	}

    
    public function cancel(Order $order)
	{
		return view('admin.orders.cancel', compact('order'));
    }
    
    public function doCancel(Request $request, Order $order)
	{
		$request->validate(
			[
				'cancellation_note' => 'required|max:255',
			]
		);
		
		$cancelOrder = \DB::transaction(
			function () use ($order, $request) {
				$params = [
					'status' => Order::CANCELLED,
					'cancelled_by' => auth()->id(),
					'cancelled_at' => now(),
					'cancellation_note' => $request->input('cancellation_note'),
				];

				if ($cancelOrder = $order->update($params) && $order->orderItems->count() > 0) {
					foreach ($order->orderItems as $item) {
						ProductInventory::increaseStock($item->product_id, $item->qty);
					}
				}
				
				return $cancelOrder;
			}
		);

		// \Session::flash('success', 'The order has been cancelled');

		return redirect('admin/orders');
	}

    public function doComplete(Request $request,Order $order)
	{		
		if (!$order->isDelivered()) {
			return redirect('admin/orders');
		}

		$order->status = Order::COMPLETED;
		$order->approved_by = auth()->id();
		$order->approved_at = now();
		
		if ($order->save()) {
			return redirect('admin/orders');
		}
	}

    public function trashed()
	{
		$orders = Order::onlyTrashed()->latest()->get();

		return view('admin.orders.trashed', compact('orders'));
	}

	public function restore($id)
	{
		$order = Order::onlyTrashed()->findOrFail($id);
		
		$canRestore = \DB::transaction(
			function () use ($order) {
				$isOutOfStock = false;
				if (!$order->isCancelled()) {
					foreach ($order->orderItems as $item) {
						try {
							ProductInventory::reduceStock($item->product_id, $item->qty);
						} catch (OutOfStockException $e) {
							$isOutOfStock = true;
							\Session::flash('error', $e->getMessage());
						}
					}
				};

				if ($isOutOfStock) {
					return false;
				} else {
					return $order->restore();
				}
			}
		);

		if ($canRestore) {
			return redirect('admin/orders');
		} else {
			return redirect('admin/orders/trashed');
		}
	}
}
