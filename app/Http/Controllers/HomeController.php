<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\OrderMaster;
use App\Models\Product;
use App\Models\SupplierMaster;
use Illuminate\Http\Request;
use PDF;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->common_data = [
            'title' => 'Dashboard',
            'view' => '',
            'route' => '',
            'module' => '',
        ];
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function days() {
        $first_day_this_month = date('01');
        $last_day_this_month  = date('t');
        $currentMontsDays = [];
        $orderAmount = [];
        $amount = 0;
        for($day=round($first_day_this_month);$day<=round($last_day_this_month);$day++) {
            array_push($currentMontsDays,$day.date('-M'));
            $date = date('Y-m-').$day;
            $amount = OrderMaster::whereDate('order_date',$date)->sum('final_total');
            array_push($orderAmount,$amount);
            $amount = 0;
        }

       return [
            'orderAmount' => $orderAmount,
            'currentMontsDays' => $currentMontsDays
        ];
    }

    public function index()
    {
        $total_order    = OrderMaster::count();
        $total_customer = Customer::count();
        $total_supplier = SupplierMaster::count();
        $total_product  = Product::count();

        $dashboard = [
            'total_order' => $total_order,
            'total_customer' => $total_customer,
            'total_supplier' => $total_supplier,
            'total_product' => $total_product,
            'currentMontsDays' => $this->days()['currentMontsDays'],
            'orderAmount'   => $this->days()['orderAmount']
        ];

        $data = $this->common_data;
        return view('dashboard', compact('data', 'dashboard'));
    }
    public function pdf_demo()
    {
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y')
        ];

        $pdf = PDF::loadView('pdf.pdf_demo', $data);

        return $pdf->stream('pdf_demo.pdf');
    }
}
