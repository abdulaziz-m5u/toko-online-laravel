<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Exports\ReportPayment;
use App\Exports\ReportProduct;
use App\Exports\ReportRevenue;
use App\Exports\ReportInventory;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

use PDF;

class ReportController extends Controller
{

    private $exports;
    public function __construct()
	{
        parent::__construct();
        
		$this->exports = [
			'xlsx' => 'Excel File',
			'pdf' => 'PDF File',
		];
	}

    public function revenue(Request $request)
    {
        $exports = $this->exports;
        
        $startDate = $request->input('start');
        $endDate = $request->input('end');

        if ($startDate && !$endDate) {
            // \Session::flash('error', 'The end date is required if the start date is present');
            return redirect('admin/reports/revenue');
        }

        if (!$startDate && $endDate) {
            // \Session::flash('error', 'The start date is required if the end date is present');
            return redirect('admin/reports/revenue');
        }

        if ($startDate && $endDate) {
            if (strtotime($endDate) < strtotime($startDate)) {
                // \Session::flash('error', 'The end date should be greater or equal than start date');
                return redirect('admin/reports/revenue');
            }

            $earlier = new \DateTime($startDate);
            $later = new \DateTime($endDate);
            $diff = $later->diff($earlier)->format("%a");
            
            if ($diff >= 31) {
                // \Session::flash('error', 'The number of days in the date ranges should be lower or equal to 31 days');
                return redirect('admin/reports/revenue');
            }
        } else {
            $currentDate = date('Y-m-d');
            $startDate = date('Y-m-01', strtotime($currentDate));
            $endDate = date('Y-m-t', strtotime($currentDate));
        }

        $completed = Order::COMPLETED;
        $payment_status = Order::PAID;

        $t = "with recursive dates as (
            select :start_date_series date
            union all
            select dates.date + interval 1 day from dates where dates.date < :end_date_series
        ),
        filtered_orders AS (
            SELECT * 
            FROM orders
            WHERE DATE(order_date) >= :start_date
                AND DATE(order_date) <= :end_date
                AND status = :status
                AND payment_status = :payment_status
        )
        SELECT 
        DISTINCT DR.date,
        COUNT(FO.id) num_of_orders,
        COALESCE(SUM(FO.grand_total),0) gross_revenue,
        COALESCE(SUM(FO.tax_amount),0) taxes_amount,
        COALESCE(SUM(FO.shipping_cost),0) shipping_amount,
        COALESCE(SUM(FO.grand_total - FO.tax_amount - FO.shipping_cost - FO.discount_amount),0) net_revenue
    FROM dates DR
    LEFT JOIN filtered_orders FO ON DATE(order_date) = DR.date
    GROUP BY DR.date
    ORDER BY DR.date ASC";

        $revenues = \DB::select($t,[
            'start_date_series' => $startDate,
            'end_date_series' => $endDate,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => Order::COMPLETED,
            'payment_status' => Order::PAID,
        ]);

        $revenues = ($startDate && $endDate) ? $revenues : [];

        if ($exportAs = $request->input('export')) {
            if (!in_array($exportAs, ['xlsx', 'pdf'])) {
                // \Session::flash('error', 'Invalid export request');
                return redirect('admin/reports/revenue');
            }

            if ($exportAs == 'xlsx') {
                $fileName = 'report-revenue-'. $startDate .'-'. $endDate .'.xlsx';

                return Excel::download(new ReportRevenue($revenues), $fileName);
            }

            if ($exportAs == 'pdf') {
                $fileName = 'report-revenue-'. $startDate .'-'. $endDate .'.pdf';
                $pdf = PDF::loadView('admin.reports.exports.pdf_revenue', compact('revenues','startDate','endDate'));

                return $pdf->download($fileName);
            }
        }

        return view('admin.reports.revenue', compact('revenues','exports'));
    }

    public function product(Request $request)
	{
        $exports = $this->exports;

		$startDate = $request->input('start');
		$endDate = $request->input('end');

		if ($startDate && !$endDate) {
			// \Session::flash('error', 'The end date is required if the start date is present');
			return redirect('admin/reports/product');
		}

		if (!$startDate && $endDate) {
			// \Session::flash('error', 'The start date is required if the end date is present');
			return redirect('admin/reports/product');
		}

		if ($startDate && $endDate) {
			if (strtotime($endDate) < strtotime($startDate)) {
				// \Session::flash('error', 'The end date should be greater or equal than start date');
				return redirect('admin/reports/product');
			}

			$earlier = new \DateTime($startDate);
			$later = new \DateTime($endDate);
			$diff = $later->diff($earlier)->format("%a");
			
			if ($diff >= 31) {
				// \Session::flash('error', 'The number of days in the date ranges should be lower or equal to 31 days');
				return redirect('admin/reports/product');
			}
		} else {
			$currentDate = date('Y-m-d');
			$startDate = date('Y-m-01', strtotime($currentDate));
			$endDate = date('Y-m-t', strtotime($currentDate));
		}

		$sql = "
		SELECT
			OI.product_id,
			OI.name,
			OI.sku,
			SUM(OI.qty) as items_sold,
			COALESCE(SUM(OI.sub_total - OI.tax_amount - OI.discount_amount),0) net_revenue,
			COUNT(OI.order_id) num_of_orders,
			PI.qty as stock
		FROM order_items OI
		LEFT JOIN orders O ON O.id = OI.order_id
		LEFT JOIN product_inventories PI ON PI.product_id = OI.product_id
		WHERE DATE(O.order_date) >= :start_date
			AND DATE(O.order_date) <= :end_date
			AND O.status = :status
			AND O.payment_status = :payment_status
		GROUP BY OI.product_id, OI.name, OI.sku, PI.qty
		";

		$products = \DB::select(
			$sql,
			[
				'start_date' => $startDate,
				'end_date' => $endDate,
				'status' => Order::COMPLETED,
				'payment_status' => Order::PAID,
			]
		);

		$products = ($startDate && $endDate) ? $products : [];

		if ($exportAs = $request->input('export')) {
			if (!in_array($exportAs, ['xlsx', 'pdf'])) {
				// \Session::flash('error', 'Invalid export request');
				return redirect('admin/reports/product');
			}

			if ($exportAs == 'xlsx') {
				$fileName = 'report-product-'. $startDate .'-'. $endDate .'.xlsx';

				return Excel::download(new ReportProduct($products), $fileName);
			}

			if ($exportAs == 'pdf') {
				$fileName = 'report-product-'. $startDate .'-'. $endDate .'.pdf';
				$pdf = PDF::loadView('admin.reports.exports.pdf_product', compact('products','startDate','endDate'));

				return $pdf->download($fileName);
			}
		}

		return view('admin.reports.product', compact('products', 'exports'));
    }
    
    public function inventory(Request $request)
	{
        $exports = $this->exports;

		$sql = "
		SELECT
			P.*,
			PI.qty as stock
		FROM product_inventories PI
		LEFT JOIN products P ON P.id = PI.product_id
		ORDER BY stock ASC
		";

		$products = \DB::select($sql);

		if ($exportAs = $request->input('export')) {
			if (!in_array($exportAs, ['xlsx', 'pdf'])) {
				// \Session::flash('error', 'Invalid export request');
				return redirect('admin/reports/inventory');
			}

			if ($exportAs == 'xlsx') {
				$fileName = 'report-inventory.xlsx';

				return Excel::download(new ReportInventory($products), $fileName);
			}

			if ($exportAs == 'pdf') {
				$fileName = 'report-inventory.pdf';
				$pdf = PDF::loadView('admin.reports.exports.pdf_inventory', compact('products'));

				return $pdf->download($fileName);
			}
		}

		return view('admin.reports.inventory', compact('products', 'exports'));
    }
    
    public function payment(Request $request)
	{
        $exports = $this->exports;

		$startDate = $request->input('start');
		$endDate = $request->input('end');

		if ($startDate && !$endDate) {
			// \Session::flash('error', 'The end date is required if the start date is present');
			return redirect('admin/reports/payment');
		}

		if (!$startDate && $endDate) {
			// \Session::flash('error', 'The start date is required if the end date is present');
			return redirect('admin/reports/payment');
		}

		if ($startDate && $endDate) {
			if (strtotime($endDate) < strtotime($startDate)) {
				// \Session::flash('error', 'The end date should be greater or equal than start date');
				return redirect('admin/reports/payment');
			}

			$earlier = new \DateTime($startDate);
			$later = new \DateTime($endDate);
			$diff = $later->diff($earlier)->format("%a");
			
			if ($diff >= 31) {
				// \Session::flash('error', 'The number of days in the date ranges should be lower or equal to 31 days');
				return redirect('admin/reports/payment');
			}
		} else {
			$currentDate = date('Y-m-d');
			$startDate = date('Y-m-01', strtotime($currentDate));
			$endDate = date('Y-m-t', strtotime($currentDate));
		}

		$sql = "
		SELECT
			O.code,
			P.*
		FROM payments P
		LEFT JOIN orders O ON O.id = P.order_id
		WHERE DATE(P.created_at) >= :start_date
			AND DATE(P.created_at) <= :end_date
		ORDER BY created_at DESC
		";

		$payments = \DB::select($sql,
			[
				'start_date' => $startDate,
				'end_date' => $endDate
			]
		);

		$payments = ($startDate && $endDate) ? $payments : [];

		if ($exportAs = $request->input('export')) {
			if (!in_array($exportAs, ['xlsx', 'pdf'])) {
				// \Session::flash('error', 'Invalid export request');
				return redirect('admin/reports/payment');
			}

			if ($exportAs == 'xlsx') {
				$fileName = 'report-payment-'. $startDate .'-'. $endDate .'.xlsx';

				return Excel::download(new ReportPayment($payments), $fileName);
			}

			if ($exportAs == 'pdf') {
				$fileName = 'report-payment-'. $startDate .'-'. $endDate .'.pdf';
				$pdf = PDF::loadView('admin.reports.exports.pdf_payment', compact('payments','startDate','endDate'));

				return $pdf->download($fileName);
			}
		}

		return view('admin.reports.payment', compact('payments', 'exports'));
	}
}
