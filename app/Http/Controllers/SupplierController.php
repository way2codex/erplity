<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Models\SupplierMaster;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{

    public function __construct()
    {
        $this->common_data = [
            'title' => 'Supplier',
            'view' => 'supplier',
            'route' => 'supplier',
            'module' => 'Supplier',
        ];
    }

    public function index()
    {
        $data = $this->common_data;
        return view($this->common_data['view'] . '.index', compact('data'));
    }

    public function get()
    {
        $data = SupplierMaster::orderBy('id', 'desc')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
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
                $btn .= '<a href="' . route('edit_supplier', encrypt($row['id'])) . '" class="btn shadow-primary waves-light btn-square btn-primary btn-sm mr-1"><i class="fa fa-pencil"></i></a>';
                // $btn .= '<button data-id="' . $row['id'] . '"  class="delete_btn delete_record btn shadow-danger waves-light btn-square btn-danger btn-sm mr-1"><i class="fa fa-trash"></i></button>';
                if ($row->status == 0) {
                    $btn .= '<a href="' . route('active_supplier', encrypt($row['id'])) . '" class="btn shadow-primary waves-light btn-square btn-info btn-sm mr-1"><i class="fa fa-check"></i></a>';
                } else {
                    $btn .= '<a href="' . route('inactive_supplier', encrypt($row['id'])) . '" class="btn shadow-primary waves-light btn-square btn-warning btn-sm mr-1"><i class="fa fa-close"></i></a>';
                }
                return $btn;
            })
            ->rawColumns(['action', 'photo', 'status'])
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
            $request->validate(['email' => 'unique:supplier_master']);
        } else if ($request->mobile) {
            $request->validate(['mobile' => 'unique:supplier_master']);
        }

        if ($request->has('image')) {
            $fileName = 'supplier_' . time() . '.' . $request->image->extension();
            $request->image->move(storage_path('app/supplier'), $fileName);
        } else {
            $fileName = null;
        }

        $request['supplier_image'] = $fileName;
        SupplierMaster::create([
            'gst_no' => $request->post('gst_no'),
            'name' => $request->post('name'),
            'mobile' => $request->post('mobile'),
            'alt_mobile' => $request->post('alt_mobile'),
            'email' => $request->post('email'),
            'city' => $request->post('city'),
            'pincode' => $request->post('pincode'),
            'address' => $request->post('address'),
            'status' => $request->post('status'),
            'photo'  => $request->post('supplier_image'),
            'created_by' => auth()->user()->id
        ]);

        Helper::message_popup($this->common_data['module'] . ' Successfully Added', 'success');
        return redirect('/' . $this->common_data['route']);
    }


    public function edit($id)
    {
        $data = $this->common_data;
        $supplier = SupplierMaster::find(decrypt($id));
        return view($this->common_data['view'] . '.edit', compact('data', 'supplier'));
    }

    public function update(Request $request)
    {
        $request->validate(['mobile' => 'unique:supplier_master,mobile,' . $request->id, 'alt_mobile' => 'unique:supplier_master,alt_mobile,' . $request->id]);

        if ($request->has('image')) {
            $fileName = 'supplier_' . time() . '.' . $request->image->extension();
            $request->image->move(storage_path('app/supplier'), $fileName);
            Helper::unlinkFile($request->old_image);
        } else {
            $fileName = array_reverse(explode('/', $request->old_image))[0] == '1.png' ? null : array_reverse(explode('/', $request->old_image))[0];
        }

        $request['supplier_image'] = $fileName;
        SupplierMaster::find($request->id)->update([
            'gst_no' => $request->post('gst_no'),
            'name' => $request->post('name'),
            'mobile' => $request->post('mobile'),
            'alt_mobile' => $request->post('alt_mobile'),
            'email' => $request->post('email'),
            'city' => $request->post('city'),
            'pincode' => $request->post('pincode'),
            'address' => $request->post('address'),
            'status' => $request->post('status'),
            'photo'  => $request->post('supplier_image'),
            'updated_by' => auth()->user()->id
        ]);

        Helper::message_popup($this->common_data['module'] . ' Successfully Added', 'success');
        return redirect('/' . $this->common_data['route']);
    }

    public function delete(Request $request)
    {
        $id = $request->post('id');
        $data = SupplierMaster::find($id);
        if ($data->image != null) {
            Helper::unlinkFile($data['photo']);
        }

        $data->delete();
        Helper::message_popup($this->common_data['module'] . ' Successfully Deleted',  'success');
        return true;
    }

    public function changeStatus($id)
    {
        if (Request()->route()->getName() == 'inactive_supplier') {
            SupplierMaster::find(decrypt($id))->update(['status' => 0]);
            Helper::message_popup($this->common_data['module'] . ' Inactive Successfully.', 'success');
        } else {
            SupplierMaster::find(decrypt($id))->update(['status' => 1]);
            Helper::message_popup($this->common_data['module'] . ' Active Successfully.', 'success');
        }

        return redirect('/' . $this->common_data['route']);
    }

    public function checkMobile(Request $request)
    {

        if (!$request->has('id')) {
            $checkMobile = SupplierMaster::where('mobile', trim($request->mobile))->count();
        } else {
            $checkMobile = SupplierMaster::where('mobile', trim($request->mobile))->where('id', '!=', $request->id)->count();
        }

        if ($checkMobile > 0) {
            return json_encode(false);
        } else {
            return json_encode(true);
        }
    }

    public function getAjaxSupplier(Request $request)
    {
        $data = [];

        if ($request->has('q')) {
            $search = $request->q;
            $data = SupplierMaster::select("id", "name")
                ->where('name', 'LIKE', "%$search%")
                ->orWhere('mobile', 'LIKE', "%$search%")
                ->get();
        } else {
            $data = SupplierMaster::select("id", "name")
                ->limit(10)
                ->get();
        }


        return response()->json($data);
    }
}
