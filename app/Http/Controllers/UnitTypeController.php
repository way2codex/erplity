<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\UnitType;
use DataTables;

class UnitTypeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->common_data = [
            'title' => 'Unit Type',
            'view' => 'unit_type',
            'route' => 'unit_type',
            'module' => 'Unit Type',
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
    public function get()
    {
        $data = UnitType::orderBy('id','desc')->get();
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
            ->addColumn('action', function ($row) {
                $btn = "";
                $btn .= '<a href="' . route('edit_unit_type', $row['id']) . '" class="btn shadow-primary waves-light btn-square btn-primary btn-sm mr-1"><i class="fa fa-pencil"></i></a>';
                $btn .= '<button data-id="' . $row['id'] . '"  class="delete_btn delete_record btn shadow-danger waves-light btn-square btn-danger btn-sm mr-1"><i class="fa fa-trash"></i></button>';

                if($row->status == 0) {
                    $btn .= '<a href="' . route('active_unit_type', encrypt($row['id'])) . '" class="btn shadow-primary waves-light btn-square btn-info btn-sm mr-1"><i class="fa fa-check"></i></a>';
                } else {
                    $btn .= '<a href="' . route('inactive_unit_type', encrypt($row['id'])) . '" class="btn shadow-primary waves-light btn-square btn-warning btn-sm mr-1"><i class="fa fa-close"></i></a>';
                }
                return $btn;
            })
            ->rawColumns(['action','status'])
            ->make(true);
    }
    public function create()
    {
        $data = $this->common_data;
        return view($this->common_data['view'] . '.create', compact('data'));
    }
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:unit_type']);
        UnitType::create([
            'name' => $request->post('name'),
            'status' => $request->post('status')
        ]);
        Helper::message_popup($this->common_data['module'] . ' Successfully Added', 'success');
        return redirect('/' . $this->common_data['route']);
    }

    public function edit($id)
    {
        $data = $this->common_data;
        $UnitType = UnitType::find($id);
        return view($this->common_data['view'] . '.edit', compact('data', 'UnitType'));
    }

    public function update(Request $request)
    {
        $request->validate(['name' => 'required|unique:unit_type,name,'.$request->name]);
        $id = $request->post('id');
        $data = UnitType::find($id);
        $data->name = $request->post('name');
        $data->status = $request->post('status');
        $data->save();

        Helper::message_popup($this->common_data['module'] . ' Successfully Updated',  'success');
        return redirect('/' . $this->common_data['route']);
    }

    public function delete(Request $request)
    {
        $id = $request->post('id');
        $data = UnitType::find($id);
        if(Product::where('unit_type_id',$data->id)->count() < 0) {
            $data->delete();
            Helper::message_popup($this->common_data['module'] . ' Successfully Deleted',  'success');
        }else{
            Helper::message_popup($this->common_data['module'] . ' Can not Deleted.', 'error');
        }
        return true;
    }

    public function changeStatus($id) {
        if(Request()->route()->getName() == 'inactive_unit_type') {
             UnitType::find(decrypt($id))->update(['status' => 0]);
             Helper::message_popup($this->common_data['module'] . ' Inactive Successfully.', 'success');
        } else {
            UnitType::find(decrypt($id))->update(['status' => 1]);
            Helper::message_popup($this->common_data['module'] . ' Active Successfully.', 'success');
        }

        return redirect('/' . $this->common_data['route']);
    }
}
