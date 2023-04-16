<?php

namespace App\Http\Controllers;

use App\Models\OrderPayments;
use App\Models\ProductCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderPaymentController extends Controller
{
    public function __construct()
    {
        $this->common_data = [
            'title' => 'Order Payments',
            'view' => 'order_payments',
            'route' => 'order_payments',
            'module' => 'Order Payments History',
        ];
    }


    public function index()
    {
        $data = $this->common_data;
        return view($this->common_data['view'] . '.index', compact('data'));
    }

    public function get(Request $request)
    {
        if($request->customer_id) {
            $customer_id = $request->customer_id;
        } else {
            $customer_id = '';
        }

        $data = OrderPayments::with(['order'])->whereHas('order',function($query) use($customer_id){
            if($customer_id != '') {
                $query->where('customer_id',$customer_id);
            }
        })->select('*');


        if ($request->today) {
            $today = date('Y-m-d');
            $data->whereDate('payment_datetime', $today);
        }

        if($request->payment_type != '') {
            $data->where('payment_type',$request->payment_type);
        }


        if ($request->from && $request->to) {
            $from = date('Y-m-d',strtotime($request->from));
            $to = date('Y-m-d',strtotime($request->to));
            $data->whereBetween('payment_datetime',[$from,$to]);
        }


        $data->orderBy('id','desc');

        return DataTables::eloquent($data)
            ->addIndexColumn()

            ->editColumn('payment_datetime',function($row) {
                return date('d-m-Y h:i:s A',strtotime($row['payment_datetime']));
            })

            ->addColumn('payment_type', function ($row) {
                if ($row['payment_type'] == 0) {
                    return "<span class='badge badge-warning'>Offline</span>";
                }
                if ($row['payment_type'] == 1) {
                    return "<span class='badge badge-success'>Online</span>";
                }
            })

            ->editColumn('amount', function ($row) {
                return $row['amount'];
            })

            ->addColumn('customer_id', function ($row) {
                return $row->order->customer->name;
            })

            ->addColumn('payment_time', function ($row) {
               return \Carbon\Carbon::parse($row->payment_datetime)->diffForHumans();
            })

            ->rawColumns(['payment_type','customer_id','payment_time'])
            ->make(true);
    }
}
