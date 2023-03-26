<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportInventory implements FromView
{

	private $_results;

	/**
	 * Create a new exporter instance.
	 *
	 * @param array $results query result
	 *
	 * @return void
	 */
	public function __construct($products)
	{
		$this->_results = $products;
	}

	/**
	 * Load the view.
	 *
	 * @return void
	 */
	public function view(): View
	{
		return view(
			'admin.reports.exports.excel_inventory',
			[
				'products' => $this->_results,
			]
		);
	}
}