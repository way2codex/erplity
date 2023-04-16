<?php

namespace App\Http\Controllers;

use DataTables;
use App\Helpers\Helper;
use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderMaster;
use App\Models\OrderPayments;
use Illuminate\Http\Request;
use App\Models\OrderProducts;
use Illuminate\Support\Carbon;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PDF;

class OrderController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->common_data = [
            'title' => 'Order',
            'view' => 'order',
            'route' => 'order',
            'module' => 'Order',
        ];
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = $this->common_data;
        return view($this->common_data['view'] . '.index', compact('data'));
    }
    public function get(Request $request)
    {
        $data = OrderMaster::with(['customer', 'order_product'])->select('*');

        if ($request->from && $request->to) {
            $from = date('Y-m-d', strtotime($request->from));
            $to = date('Y-m-d', strtotime($request->to));
            $data->whereBetween('order_date', [$from, $to]);
        }


        if ($request->due_date) {
            $date = date('Y-m-d', strtotime($request->due_date));
            $data->whereDate('due_date', $date);
        }

        if ($request->today) {
            $today = date('Y-m-d');
            $data->whereDate('order_date', $today);
        }

        if ($request->customer_id) {
            $data->where('customer_id', $request->customer_id);
        }

        if ($request->payment_status) {
            $data->where('payment_status', $request->payment_status);
        }

        $data->orderBy('id', 'desc');

        return DataTables::eloquent($data)
            ->addIndexColumn()
            ->addColumn('customer_id', function ($row) {
                return $row['customer']['name'];
            })

            ->addColumn('total_product', function ($row) {
                return $row->order_product->unique('product_id')->count();
            })


            ->addColumn('order_date', function ($row) {
                return date('d-m-Y', strtotime($row['order_date']));
            })

            ->addColumn('action', function ($row) {
                $btn = "";
                // if ($row['debit_amount'] > 0) {
                $btn .= '<button data-id="' . $row['id'] . '"  class="add_payment_btn btn shadow-warning waves-light btn-square btn-warning btn-sm mr-1" data-toggle="tooltip" title="Payment"><span class="fa fa-credit-card"></span></button>';
                // }
                $btn .= '<a target="_blank" href="' . route('order_pdf', $row['id']) . '" class="btn shadow-danger waves-light btn-square btn-danger btn-sm mr-1" data-toggle="tooltip" title="Pdf"><span class="fa fa-file-pdf-o"></span></a>';
                $btn .= '<a href="' . route('view_order', $row['id']) . '" class="btn shadow-primary waves-light btn-square btn-primary btn-sm mr-1" data-toggle="tooltip" title="Edit"><span class="fa fa-eye"></span></a>';
                if ($row['credit_amount'] <= 0) {
                    $btn .= '<button data-id="' . $row['id'] . '"  class="delete_btn delete_record btn shadow-danger waves-light btn-square btn-danger btn-sm mr-1" data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></span></button>';
                } else {
                    $btn .= '<button data-id="' . $row['id'] . '"  class="delete_btn delete_record_warning btn shadow-danger waves-light btn-square btn-danger btn-sm mr-1" data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></span></button>';
                }

                return $btn;
            })
            ->rawColumns(['action', 'total_product', 'customer_id', 'payment_status'])
            ->make(true);
    }
    public function order_pdf($id)
    {

        $data_item = OrderMaster::with('order_product.product', 'customer')->where('id', $id)->first();

        $data = [
            'title' => 'Order Pdf',
            'data' => $data_item
        ];

        $pdf = PDF::loadView('pdf.order', $data);

        return $pdf->stream($data_item['order_no'] . '_order_pdf.pdf');
    }
    public function create()
    {
        $data = $this->common_data;
        $products = Product::active()->get();
        $customer = Customer::active()->get();
        return view($this->common_data['view'] . '.create', compact('data', 'customer', 'products'));
    }
    public function store(Request $request)
    {

        $data = OrderMaster::create([
            'customer_id' => $request->post('customer_id'),
            'order_no' => 0,
            'total' => $request->post('total') ?? 0.00,
            'discount' => $request->post('discount') ?? 0.00,
            'final_total' => $request->post('final_total') ?? 0.00,
            'debit_amount' => $request->post('final_total') ?? 0.00,
            'credit_amount' => 0.00,
            'created_by' => Auth::user()['id'],
            'order_date' => Carbon::parse($request->post('order_date'))->format('Y-m-d'),
            'due_date' => Carbon::parse($request->post('due_date'))->format('Y-m-d'),
            'created_by' => auth()->user()->id
        ]);

        if ($data) {
            OrderMaster::find($data->id)->update(['order_no' => 'ORD' . $data->id]);
        }

        $order_id = $data['id'];
        if (!empty($request->post('order_product'))) {
            foreach ($request->post('order_product') as $key => $item) {
                $order_product_data = new OrderProducts();
                $order_product_data->order_id = $order_id;
                $order_product_data->product_id = $item['product_id'];
                $order_product_data->quantity = $item['quantity'];
                $order_product_data->rate = $item['rate'];
                $order_product_data->gst_percentage = $item['gst_percentage'];
                $order_product_data->gst_amount = $item['gst_amount'];
                $order_product_data->total = $item['total'];
                $order_product_data->save();

                $stock_transaction = new StockTransaction();
                $stock_transaction->ref_number = $order_id;
                $stock_transaction->ref_comment = 'Sell Order';
                $stock_transaction->product_id = $item['product_id'];
                $stock_transaction->quantity = $item['quantity'];
                $stock_transaction->transaction_type = 'out';
                $stock_transaction->save();

                $product_data = Product::where('id', $item['product_id'])->first();
                $product_data->current_stock = $product_data['current_stock'] - $item['quantity'];
                $product_data->save();
            }
        }

        $payment_received = $request->post('payment_received');
        if ($payment_received == true) {


            $amount = $request->post('final_total');
            $order_id = $order_id;
            $data = new OrderPayments();
            $data->order_id = $order_id;
            $data->amount = $amount;
            $data->payment_datetime = date('Y-m-d H:i:s');
            $data->payment_type = $request->post('payment_type');
            $data->save();

            $order_data = OrderMaster::where('id', $order_id)->first();
            $order_data->credit_amount = (int)$amount;
            $order_data->debit_amount = 0;
            $order_data->payment_status = 'paid';
            $order_data->save();
        }

        Helper::message_popup($this->common_data['module'] . ' Successfully Added', 'success');
        return redirect('/' . $this->common_data['route']);
    }


    public function show($id)
    {
        $order = OrderMaster::with(['customer', 'order_product', 'order_payment'])->find($id);
        $data = $this->common_data;
        return view($this->common_data['view'] . '/view', compact('data', 'order'));
    }

    public function update(Request $request)
    {
    }

    public function delete(Request $request)
    {
        $id = $request->post('id');
        $data = OrderMaster::with('order_product.product')
            ->where('id', $id)
            ->first();
        foreach ($data->order_product as $key => $item) {
            $order_id = $data['id'];
            $product_id = $item['product']['id'];
            $update_stock = $item['product']['current_stock'] + $item['quantity'];
            $prod_data = Product::where('id', $product_id)
                ->first();
            $prod_data->current_stock = $update_stock;
            $prod_data->save();

            $stock_transaction = StockTransaction::where('ref_number', $order_id)
                ->where('product_id', $product_id)
                ->where('quantity', $item['quantity'])
                ->where('transaction_type', 'out')
                ->first();
            $stock_transaction->forceDelete();
        }
        $data->forceDelete();
        Helper::message_popup($this->common_data['module'] . ' Successfully Deleted',  'success');
        return true;
    }
    public function get_product_stock(Request $request)
    {
        $product_id = $request->post('product_id');
        $data = Product::where('id', $product_id)->first();
        $stock = $data['current_stock'] ?? 0;
        $moq = $data['minimumn_order_quantity'] ?? 0;
        $rate = $data['rate'] ?? 0;
        return response()->json([
            'stock' => $stock,
            'moq' => $moq,
            'rate' => $rate
        ]);
    }
    public function order_payment_store(Request $request)
    {
        $amount = $request->post('amount');
        $order_id = $request->post('order_id');
        $data = new OrderPayments();
        $data->order_id = $order_id;
        $data->amount = $amount;
        $data->payment_datetime = Carbon::parse($request->post('payment_datetime'))->format('Y-m-d H:i:s');
        $data->payment_type = $request->post('payment_type');
        $data->save();

        $order_data = OrderMaster::where('id', $order_id)->first();
        $order_data->credit_amount = (int)$order_data['credit_amount'] + (int)$amount;
        $order_data->debit_amount = (int)$order_data['debit_amount'] - (int)$amount;
        if (((int)$order_data['debit_amount'] - (int)$amount) <= 0) {
            $order_data->payment_status = 'paid';
        }
        $order_data->save();
        Helper::message_popup($this->common_data['module'] . ' Successfully Updated',  'success');
        return response()->json(['status' => true]);
    }
    public function order_payment_popup(Request $request)
    {
        $id = $request->post('id');

        $returnData = array();
        $returnData['id'] = $id;

        $order = OrderMaster::with('order_payment', 'order_product')->where('id', $id)->first();
        $returnData['order'] = $order;
        $returnHTML = view($this->common_data['view'] . '.payment_popup', $returnData)->render();
        return response()->json(['status' => true, 'html' => $returnHTML]);
    }
}
