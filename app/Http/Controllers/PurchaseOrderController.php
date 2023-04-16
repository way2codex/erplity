<?php

namespace App\Http\Controllers;

use DataTables;

use App\Helpers\Helper;
use App\Models\Product;
use App\Models\UnitType;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\SupplierMaster;
use Illuminate\Support\Carbon;
use App\Models\PurchaseOrderPayments;
use App\Models\StockTransaction;
use App\Models\PurchaseOrderProduct;
use Illuminate\Support\Facades\Auth;

class PurchaseOrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->common_data = [
            'title' => 'Purchase Order',
            'view' => 'purchase_order',
            'route' => 'purchase_order',
            'module' => 'Purchase Order',
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
        $data = PurchaseOrder::with(['supplier'])->select('*');

        if ($request->from && $request->to) {
            $from = date('Y-m-d', strtotime($request->from));
            $to = date('Y-m-d', strtotime($request->to));
            $data->whereBetween('order_date', [$from, $to]);
        }

        $data->orderBy('id', 'desc');

        if ($request->supplier_id) {
            $data->where('supplier_id', $request->supplier_id);
        }

        return DataTables::eloquent($data)
            ->addIndexColumn()
            ->editColumn('status', function ($row) {
                if ($row['status'] == 0) {
                    return 'InActive';
                }
                if ($row['status'] == 1) {
                    return 'Active';
                }
            })
            ->editColumn('supplier_id', function ($row) {
                return $row['supplier']['name'];
            })

            ->editColumn('order_date', function ($row) {
                return date('d-m-Y', strtotime($row['order_date']));
            })
            ->addColumn('action', function ($row) {
                $btn = "";
                $btn .= '<button data-id="' . $row['id'] . '"  class="add_payment_btn btn shadow-warning waves-light btn-square btn-warning btn-sm mr-1" data-toggle="tooltip" title="Payment"><span class="fa fa-credit-card"></span></button>';
                $btn .= '<a href="' . route('view_purchase_order', encrypt($row['id'])) . '" class="btn shadow-primary waves-light btn-square btn-primary btn-sm mr-1"><span class="fa fa-eye"><span></a>';
                if ($row['credit_amount'] <= 0) {
                    $btn .= '<button data-id="' . $row['id'] . '"  class="delete_btn delete_record btn shadow-danger waves-light btn-square btn-danger btn-sm mr-1"><span class="fa fa-trash"><span></button>';
                } else {
                    $btn .= '<button data-id="' . $row['id'] . '"  class="delete_btn delete_record_warning btn shadow-danger waves-light btn-square btn-danger btn-sm mr-1"><span class="fa fa-trash"><span></button>';
                }
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function create()
    {
        $data = $this->common_data;
        $products = Product::get();
        $supplier = SupplierMaster::active()->get();
        return view($this->common_data['view'] . '.create', compact('data', 'supplier', 'products'));
    }
    public function store(Request $request)
    {

        $data = PurchaseOrder::create([
            'supplier_id' => $request->post('supplier_id'),
            'order_no' => 0,
            'total' => $request->post('total') ?? 0.00,
            'discount' => $request->post('discount') ?? 0.00,
            'final_total' => $request->post('final_total') ?? 0.00,
            'debit_amount' => $request->post('final_total') ?? 0.00,
            'credit_amount' => 0.00,
            'created_by' => Auth::user()['id'],
            'order_date' => Carbon::parse($request->post('order_date'))->format('Y-m-d'),
            'created_by' => auth()->user()->id
        ]);

        if ($data) {
            PurchaseOrder::find($data->id)->update(['order_no' => 'ORD' . $data->id]);
        }

        $order_id = $data['id'];
        if (!empty($request->post('purchase_order_product'))) {
            foreach ($request->post('purchase_order_product') as $key => $item) {
                $order_product_data = new PurchaseOrderProduct();
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
                $stock_transaction->ref_comment = 'Purchase Order';
                $stock_transaction->product_id = $item['product_id'];
                $stock_transaction->quantity = $item['quantity'];
                $stock_transaction->transaction_type = 'in';
                $stock_transaction->save();

                $product_data = Product::where('id', $item['product_id'])->first();
                $product_data->current_stock = $product_data['current_stock'] + $item['quantity'];
                $product_data->save();
            }
        }

        Helper::message_popup($this->common_data['module'] . ' Successfully Added', 'success');
        return redirect('/' . $this->common_data['route']);
    }

    public function edit($id)
    {
    }

    public function show($id)
    {
        $order = PurchaseOrder::with(['purchase_order_product', 'supplier'])->find(decrypt($id));
        $data = $this->common_data;
        return view($this->common_data['view'] . '/view', compact('order', 'data'));
    }

    public function update(Request $request)
    {
    }

    public function delete(Request $request)
    {
        $id = $request->post('id');
        $data = PurchaseOrder::with('purchase_order_product.product')
            ->where('id', $id)
            ->first();
        foreach ($data->purchase_order_product as $key => $item) {
            $order_id = $data['id'];
            $product_id = $item['product']['id'];
            $update_stock = $item['product']['current_stock'] - $item['quantity'];
            $prod_data = Product::where('id', $product_id)
                ->first();
            $prod_data->current_stock = $update_stock;
            $prod_data->save();

            $stock_transaction = StockTransaction::where('ref_number', $order_id)
                ->where('product_id', $product_id)
                ->where('quantity', $item['quantity'])
                ->where('transaction_type', 'in')
                ->first();
            $stock_transaction->forceDelete();
        }
        $data->forceDelete();
        Helper::message_popup($this->common_data['module'] . ' Successfully Deleted',  'success');
        return true;
    }

    public function purchase_order_payment_store(Request $request)
    {
        $amount = $request->post('amount');
        $order_id = $request->post('order_id');
        $data = new PurchaseOrderPayments();
        $data->order_id = $order_id;
        $data->amount = $amount;
        $data->payment_datetime = Carbon::parse($request->post('payment_datetime'))->format('Y-m-d H:i:s');
        $data->payment_type = $request->post('payment_type');
        $data->save();

        $order_data = PurchaseOrder::where('id', $order_id)->first();
        $order_data->credit_amount = (int)$order_data['credit_amount'] + (int)$amount;
        $order_data->debit_amount = (int)$order_data['debit_amount'] - (int)$amount;
        if (((int)$order_data['debit_amount'] - (int)$amount) <= 0) {
            $order_data->payment_status = 'paid';
        }
        $order_data->save();
        Helper::message_popup($this->common_data['module'] . ' Successfully Updated',  'success');
        return response()->json(['status' => true]);
    }
    public function purchase_order_payment_popup(Request $request)
    {
        $id = $request->post('id');

        $returnData = array();
        $returnData['id'] = $id;

        $order = PurchaseOrder::with('order_payment', 'purchase_order_product')->where('id', $id)->first();
        $returnData['order'] = $order;
        $returnHTML = view($this->common_data['view'] . '.payment_popup', $returnData)->render();
        return response()->json(['status' => true, 'html' => $returnHTML]);
    }
}
