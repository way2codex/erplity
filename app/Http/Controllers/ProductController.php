<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\UnitType;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use DataTables;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->common_data = [
            'title' => 'Product',
            'view' => 'product',
            'route' => 'product',
            'module' => 'Product',
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
        $data = Product::with('category')->select('*')->orderBy('id', 'desc');;

        if ($request->category_id) {
            $data->where('category_id', $request->category_id);
        }

        return DataTables::eloquent($data)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                if ($row['status'] == 0) {
                    return "<span class='badge badge-warning'>InActive</span>";
                }
                if ($row['status'] == 1) {
                    return "<span class='badge badge-info'>Active</span>";
                }
            })
            ->editColumn('status', function ($row) {
                if ($row['status'] == 0) {
                    return "<span class='badge badge-warning'>InActive</span>";
                }
                if ($row['status'] == 1) {
                    return "<span class='badge badge-info'>Active</span>";
                }
            })
            ->addColumn('action', function ($row) {
                $btn = "";
                $btn .= '<a href="' . route('edit_product', $row['id']) . '" class="btn shadow-primary waves-light btn-square btn-primary btn-sm mr-1"><i class="fa fa-pencil"></i></a>';
                $btn .= '<button data-id="' . $row['id'] . '"  class="delete_btn delete_record btn shadow-danger waves-light btn-square btn-danger btn-sm mr-1"><i class="fa fa-trash"></i></button>';
                if ($row->status == 0) {
                    $btn .= '<a href="' . route('active_product', encrypt($row['id'])) . '" class="btn shadow-primary waves-light btn-square btn-info btn-sm mr-1"><i class="fa fa-check"></i></a>';
                } else {
                    $btn .= '<a href="' . route('inactive_product', encrypt($row['id'])) . '" class="btn shadow-primary waves-light btn-square btn-warning btn-sm mr-1"><i class="fa fa-close"></i></a>';
                }
                return $btn;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }
    public function create()
    {
        $data = $this->common_data;
        $unit_type = UnitType::active()->get();
        $category = ProductCategory::active()->get();
        return view($this->common_data['view'] . '.create', compact('data', 'category', 'unit_type'));
    }
    public function store(Request $request)
    {

        $main_image = "default.jpg";
        if ($request->hasfile('main_image')) {
            $main_image = 'product_' .  rand(1111111111, 9999999999)   . '.' . $request->main_image->extension();
            $request->main_image->move(storage_path('app/product'), $main_image);
        }

        $data = Product::create([
            'name' => $request->post('name'),
            'category_id' => $request->post('category_id'),
            'unit_type_id' => $request->post('unit_type_id'),
            'status' => $request->post('status'),
            'rate' => $request->post('rate'),
            'hsn_code' => $request->post('hsn_code'),
            'description' => $request->post('description'),
            'main_image' => $main_image,
            'minimumn_order_quantity' => $request->post('minimumn_order_quantity'),
            'stock_alert_quantity' => $request->post('stock_alert_quantity')
        ]);
        $product_id = $data['id'];
        if ($request->file('product_images')) {
            foreach ($request->file('product_images') as $image_key => $file) {
                if ($file['product_image']) {
                    $name = 'product_' . $image_key . rand(1111111111, 9999999999)  . '.' . $file['product_image']->extension();
                    $file['product_image']->move(storage_path('app/product'), $name);
                    $image_data = ProductImage::create([
                        'product_id' => $product_id,
                        'image' => $name
                    ]);
                }
            }
        }
        Helper::message_popup($this->common_data['module'] . ' Successfully Added', 'success');
        return redirect('/' . $this->common_data['route']);
    }

    public function edit($id)
    {
        $data = $this->common_data;
        $product = Product::with('category', 'product_images')->where('id', $id)->first();
        $unit_type = UnitType::active()->get();
        $category = ProductCategory::active()->get();
        return view($this->common_data['view'] . '.edit', compact('data', 'unit_type', 'category', 'product'));
    }

    public function update(Request $request)
    {
        $product_id = $request->post('id');

        $main_image = $request->post('old_main_image');
        if ($request->hasfile('main_image')) {
            $main_image = 'product_' .  rand(1111111111, 9999999999)   . '.' . $request->main_image->extension();
            $request->main_image->move(storage_path('app/product'), $main_image);
        }

        $data = Product::find($product_id)
            ->update([
                'name' => $request->post('name'),
                'category_id' => $request->post('category_id'),
                'unit_type_id' => $request->post('unit_type_id'),
                'status' => $request->post('status'),
                'rate' => $request->post('rate'),
                'hsn_code' => $request->post('hsn_code'),
                'description' => $request->post('description'),
                'main_image' => $main_image,
                'minimumn_order_quantity' => $request->post('minimumn_order_quantity'),
                'stock_alert_quantity' => $request->post('stock_alert_quantity')
            ]);
        if ($request->file('product_images')) {
            foreach ($request->file('product_images') as $image_key => $file) {
                if ($file['product_image']) {
                    $name = 'product_' . $image_key . rand(1111111111, 9999999999)  . '.' . $file['product_image']->extension();
                    $file['product_image']->move(storage_path('app/product'), $name);
                    $image_data = ProductImage::create([
                        'product_id' => $product_id,
                        'image' => $name
                    ]);
                }
            }
        }
        Helper::message_popup($this->common_data['module'] . ' Successfully Updated', 'success');
        return redirect('/' . $this->common_data['route']);
    }

    public function delete(Request $request)
    {
        $id = $request->post('id');
        $data = Product::find($id);
        $data->delete();
        Helper::message_popup($this->common_data['module'] . ' Successfully Deleted',  'success');
        return true;
    }
    public function delete_product_image(Request $request)
    {
        $id = $request->post('id');
        $data = ProductImage::find($id);
        Helper::unlinkFile(url('storage/app/product/' . $data['image']));
        $data->forceDelete();
        return true;
    }

    public function changeStatus($id)
    {
        if (Request()->route()->getName() == 'inactive_product') {
            Product::find(decrypt($id))->update(['status' => 0]);
            Helper::message_popup($this->common_data['module'] . ' Inactive Successfully.', 'success');
        } else {
            Product::find(decrypt($id))->update(['status' => 1]);
            Helper::message_popup($this->common_data['module'] . ' Active Successfully.', 'success');
        }

        return redirect('/' . $this->common_data['route']);
    }
}
