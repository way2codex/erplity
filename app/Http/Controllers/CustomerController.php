<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Customer;
use App\Models\OrderMaster;
use App\Models\OrderPayments;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->common_data = [
            'title' => 'Customer',
            'view' => 'customer',
            'route' => 'customer',
            'module' => 'Customer',
        ];
    }

    public function index()
    {
        $data = $this->common_data;
        return view($this->common_data['view'] . '.index', compact('data'));
    }

    public function get()
    {
        $data = Customer::get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('status', function ($row) {
                if ($row['status'] == 0) {
                    return "<span class='badge badge-warning'>InActive</span>";
                }
                if ($row['status'] == 1) {
                    return "<span class='badge badge-info'>Active</span>";
                }
            })

            ->addColumn('photo', function ($row) {
                $image = "<img src=" . $row['photo'] . " width='50px'>";
                return $image;
            })

            ->addColumn('action', function ($row) {
                $btn = "";
                $btn .= '<a href="' . route('view_customer', encrypt($row['id'])) . '" class="btn shadow-primary waves-light btn-square btn-primary btn-sm mr-1">View</a>';
                $btn .= '<a href="' . route('edit_customer', encrypt($row['id'])) . '" class="btn shadow-primary waves-light btn-square btn-primary btn-sm mr-1"><i class="fa fa-pencil"></i></a>';
                // $btn .= '<button data-id="' . $row['id'] . '"  class="delete_btn delete_record btn shadow-danger waves-light btn-square btn-danger btn-sm mr-1"><i class="fa fa-trash"></i></button>';
                if ($row->status == 0) {
                    $btn .= '<a href="' . route('active_customer', encrypt($row['id'])) . '" class="btn shadow-primary waves-light btn-square btn-info btn-sm mr-1"><i class="fa fa-check"></i></a>';
                } else {
                    $btn .= '<a href="' . route('inactive_customer', encrypt($row['id'])) . '" class="btn shadow-primary waves-light btn-square btn-warning btn-sm mr-1"><i class="fa fa-close"></i></a>';
                }
                return $btn;
            })
            ->rawColumns(['action', 'photo', 'status'])
            ->make(true);
    }
    public function get_customer_order(Request $request)
    {
        $id = $request->post('id');
        $data = OrderMaster::where('customer_id', $id)->orderBy('id', 'desc')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = "";
                $btn .= '<button data-id="' . $row['id'] . '"  class="order_info_btn btn shadow-primary waves-light btn-square btn-primary btn-sm mr-1">Details & Payments</button>';
                return $btn;
            })

            ->editColumn('order_date', function ($row) {
                return date('d-m-Y', strtotime($row['order_date']));
            })
            ->rawColumns(['action',])
            ->make(true);
    }
    public function get_customer_payment(Request $request)
    {
        $id = $request->post('id');
        $data = OrderPayments::with('order')->whereHas('order', function ($query) use ($id) {
            $query->where('customer_id',  $id);
        })->orderBy('id', 'desc');
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('order_id', function ($row) {
                return $row['order']['order_no'];
            })
            ->editColumn('payment_datetime', function ($row) {
                return date('d-m-Y h:i:s A', strtotime($row['payment_datetime']));
            })
            ->editColumn('payment_type', function ($row) {
                if ($row['payment_type'] == 0) {
                    return 'Offline';
                }
                if ($row['payment_type'] == 1) {
                    return 'Online';
                }
            })
            ->rawColumns(['action',])
            ->make(true);
    }

    public function create()
    {
        $data = $this->common_data;
        return view($this->common_data['view'] . '.create', compact('data'));
    }


    public function store(Request $request)
    {
        if ($request->email != '') {
            $request->validate(['email' => 'unique:customer']);
        } else if ($request->mobile != '') {
            $request->validate(['mobile' => 'unique:customer']);
        }

        if ($request->has('image')) {
            $fileName = 'customer_' . time() . '.' . $request->image->extension();
            $request->image->move(storage_path('app/customer'), $fileName);
        } else {
            $fileName = null;
        }

        $request['customer_image'] = $fileName;
        Customer::create([
            'gst_no' => $request->post('gst_no'),
            'name' => $request->post('name'),
            'mobile' => $request->post('mobile'),
            'alt_mobile' => $request->post('alt_mobile'),
            'email' => $request->post('email'),
            'city' => $request->post('city'),
            'pincode' => $request->post('pincode'),
            'address' => $request->post('address'),
            'status' => $request->post('status'),
            'photo'  => $request->post('customer_image'),
            'created_by' => auth()->user()->id
        ]);

        Helper::message_popup($this->common_data['module'] . ' Successfully Added', 'success');
        return redirect('/' . $this->common_data['route']);
    }


    public function edit($id)
    {
        $data = $this->common_data;
        $customer = Customer::find(decrypt($id));
        return view($this->common_data['view'] . '.edit', compact('data', 'customer'));
    }

    public function update(Request $request)
    {
        if ($request->has('image')) {
            $fileName = 'customer_' . time() . '.' . $request->image->extension();
            $request->image->move(storage_path('app/customer'), $fileName);
            Helper::unlinkFile($request->old_image);
        } else {
            $fileName = array_reverse(explode('/', $request->old_image))[0] == '1.png' ? null : array_reverse(explode('/', $request->old_image))[0];
        }

        $request['customer_image'] = $fileName;
        Customer::find($request->id)->update([
            'gst_no' => $request->post('gst_no'),
            'name' => $request->post('name'),
            'mobile' => $request->post('mobile'),
            'alt_mobile' => $request->post('alt_mobile'),
            'email' => $request->post('email'),
            'city' => $request->post('city'),
            'pincode' => $request->post('pincode'),
            'address' => $request->post('address'),
            'status' => $request->post('status'),
            'photo'  => $request->post('customer_image'),
            'updated_by' => auth()->user()->id
        ]);

        Helper::message_popup($this->common_data['module'] . ' Successfully Updated.', 'success');
        return redirect('/' . $this->common_data['route']);
    }

    public function delete(Request $request)
    {
        $id = $request->post('id');
        $data = Customer::find($id);
        if ($data->image != null) {
            Helper::unlinkFile($data['photo']);
        }

        $data->delete();
        Helper::message_popup($this->common_data['module'] . ' Successfully Deleted',  'success');
        return true;
    }

    public function changeStatus($id)
    {
        if (Request()->route()->getName() == 'inactive_customer') {
            Customer::find(decrypt($id))->update(['status' => 0]);
            Helper::message_popup($this->common_data['module'] . ' Inactive Successfully.', 'success');
        } else {
            Customer::find(decrypt($id))->update(['status' => 1]);
            Helper::message_popup($this->common_data['module'] . ' Active Successfully.', 'success');
        }

        return redirect('/' . $this->common_data['route']);
    }

    public function checkMobile(Request $request)
    {

        if (!$request->has('id')) {
            $checkMobile = Customer::where('mobile', trim($request->mobile))->count();
        } else {
            $checkMobile = Customer::where('mobile', trim($request->mobile))->where('id', '!=', $request->id)->count();
        }

        if ($checkMobile > 0) {
            return json_encode(false);
        } else {
            return json_encode(true);
        }
    }

    public function view($id)
    {
        $data = $this->common_data;
        $customer = Customer::with('orders')
            ->where('id', decrypt($id))
            ->first();

        return view($this->common_data['view'] . '.view', compact('data', 'customer'));
    }
    public function order_detail_popup(Request $request)
    {
        $id = $request->post('id');

        $returnData = array();
        $returnData['id'] = $id;

        $order = OrderMaster::with('order_payment', 'order_product.product')->where('id', $id)->first();

        $returnData['order'] = $order;
        $returnHTML = view($this->common_data['view'] . '.order_detail_popup', $returnData)->render();
        return response()->json(['status' => true, 'html' => $returnHTML]);
    }

    public function customer_payment_popup(Request $request)
    {
        $id = $request->post('id');

        $returnData = array();
        $returnData['id'] = $id;

        $order = OrderMaster::where('customer_id', $id)->where('debit_amount', '>', 0)->get();
        $customer = Customer::where('id', $id)->first();

        $returnData['order'] = $order;
        $returnData['debit_amount'] = $order->sum('debit_amount');
        $returnData['customer'] = $customer;
        $returnHTML = view($this->common_data['view'] . '.customer_payment_popup', $returnData)->render();
        return response()->json(['status' => true, 'html' => $returnHTML]);
    }
    public function customer_payment_store(Request $request)
    {
        $amount = $request->post('amount');
        $customer_id = $request->post('customer_id');

        $order = OrderMaster::where('customer_id', $customer_id)->where('debit_amount', '>', 0)->orderBy('id', 'desc')->get();
        $customer = Customer::where('id', $customer_id)->first();

        foreach ($order as $order_key => $order_item) {
            $debit_amount = (int)$order_item['debit_amount'];
            $order_data = OrderMaster::where('id', $order_item['id'])->first();
            $order_data->credit_amount = (int)$order_data['credit_amount'] + (int)$order_data['debit_amount'];
            $order_data->debit_amount = (int)$order_data['debit_amount'] - (int)$order_data['debit_amount'];
            $order_data->payment_status = 'paid';
            $order_data->save();

            $data = new OrderPayments();
            $data->order_id = $order_item['id'];
            $data->amount = $debit_amount;
            $data->payment_datetime = Carbon::parse($request->post('payment_datetime'))->format('Y-m-d H:i:s');
            $data->payment_type = $request->post('payment_type');
            $data->save();
        }
        Helper::message_popup($this->common_data['module'] . ' Successfully Updated',  'success');
        return response()->json(['status' => true]);
    }
    public function getAjaxCustomer(Request $request)
    {
        $data = [];

        if ($request->has('q')) {
            $search = $request->q;
            $data = Customer::select("id", "name")
                ->where('name', 'LIKE', "%$search%")
                ->orWhere('mobile', 'LIKE', "%$search%")
                ->get();
        } else {
            $data = Customer::select("id", "name")
                ->limit(10)
                ->get();
        }


        return response()->json($data);
    }
}
