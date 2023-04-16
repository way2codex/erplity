<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Yajra\DataTables\Facades\DataTables;

class ProductCategoryController extends Controller
{

    public function __construct()
    {
        $this->common_data = [
            'title' => 'Product Category',
            'view' => 'product_category',
            'route' => 'product_category',
            'module' => 'Product Category',
        ];
    }


    public function index()
    {
        $data = $this->common_data;
        return view($this->common_data['view'] . '.index', compact('data'));
    }

    public function get()
    {
        $data = ProductCategory::orderBy('id','desc')->get();
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
            ->addColumn('image', function ($row) {
                $image = "<img src=" . $row['image'] . " width='50px'>";
                return $image;
            })

            ->addColumn('action', function ($row) {
                $btn = "";
                $btn .= '<a href="' . route('edit_product_category', encrypt($row['id'])) . '" class="btn shadow-primary waves-light btn-square btn-primary btn-sm mr-1"><i class="fa fa-pencil"></i></a>';
                $btn .= '<button data-id="' . $row['id'] . '"  class="delete_btn delete_record btn shadow-danger waves-light btn-square btn-danger btn-sm mr-1"><i class="fa fa-trash"></i></button>';

                if ($row->status == 0) {
                    $btn .= '<a href="' . route('active_product_category', encrypt($row['id'])) . '" class="btn shadow-primary waves-light btn-square btn-info btn-sm mr-1"><i class="fa fa-check"></i></a>';
                } else {
                    $btn .= '<a href="' . route('inactive_product_category', encrypt($row['id'])) . '" class="btn shadow-primary waves-light btn-square btn-warning btn-sm mr-1"><i class="fa fa-close"></i></a>';
                }

                return $btn;
            })
            ->rawColumns(['action', 'image', 'status'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = $this->common_data;
        return view($this->common_data['view'] . '.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'unique:product_category']);

        if ($request->has('image')) {
            $fileName = 'cat_' . time() . '.' . $request->image->extension();
            $request->image->move(storage_path('app/product_category'), $fileName);
        } else {
            $fileName = null;
        }

        $request['category_image'] = $fileName;
        ProductCategory::create([
            'name' => $request->post('name'),
            'status' => $request->post('status'),
            'image'  => $request->post('category_image')
        ]);

        Helper::message_popup($this->common_data['module'] . ' Successfully Added', 'success');
        return redirect('/' . $this->common_data['route']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->common_data;
        $ProductCategory = ProductCategory::find(decrypt($id));
        return view($this->common_data['view'] . '.edit', compact('data', 'ProductCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate(['name' => 'unique:product_category,name,' . $request->id]);
        if ($request->has('image')) {
            $fileName = 'cat_' . time() . '.' . $request->image->extension();
            $request->image->move(storage_path('app/product_category'), $fileName);
            Helper::unlinkFile(url('storage/app/product_category' . $request->old_image));
        } else {
            $fileName = array_reverse(explode('/', $request->old_image))[0] == '1.png' ? null : array_reverse(explode('/', $request->old_image))[0];
        }

        $request['category_image'] = $fileName;
        ProductCategory::find($request->id)->update([
            'name' => $request->post('name'),
            'status' => $request->post('status'),
            'image'  => $request->post('category_image')
        ]);

        Helper::message_popup($this->common_data['module'] . ' Successfully Updated.', 'success');
        return redirect('/' . $this->common_data['route']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {

        $id = $request->post('id');
        $data = ProductCategory::find($id);
        $checkProduct = Product::where('category_id', $data->id)->count();
        if ($checkProduct <= 0) {
            if ($data->image != null) {
                Helper::unlinkFile($data['image']);
            }
            $data->delete();
            Helper::message_popup($this->common_data['module'] . ' Successfully Deleted', 'success');
        } else {
            Helper::message_popup($this->common_data['module'] . ' Can not Deleted.', 'error');
        }
        return true;
    }

    public function changeStatus($id)
    {
        if (Request()->route()->getName() == 'inactive_product_category') {
            ProductCategory::find(decrypt($id))->update(['status' => 0]);
            Helper::message_popup($this->common_data['module'] . ' Inactive Successfully.', 'success');
        } else {
            ProductCategory::find(decrypt($id))->update(['status' => 1]);
            Helper::message_popup($this->common_data['module'] . ' Active Successfully.', 'success');
        }

        return redirect('/' . $this->common_data['route']);
    }

    public function checkName(Request $request)
    {

        if (!$request->has('id')) {
            $checkMobile = ProductCategory::where('name', trim($request->name))->count();
        } else {
            $checkMobile = ProductCategory::where('name', trim($request->name))->where('id', '!=', $request->id)->count();
        }

        if ($checkMobile > 0) {
            return json_encode(false);
        } else {
            return json_encode(true);
        }
    }

    public function getAjaxCategory(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->q;
            $data = ProductCategory::select("id", "name")
                ->where('name', 'LIKE', "%$search%")
                ->get();
        }

        return response()->json($data);
    }
}
