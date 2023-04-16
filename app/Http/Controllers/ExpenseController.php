<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Models\ExpenseMaster;
use Yajra\DataTables\Facades\DataTables;
use PDF;
class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->common_data = [
            'title' => 'Expenses',
            'view' => 'expense',
            'route' => 'expense',
            'module' => 'Expense',
        ];
    }

    public function index()
    {
        $data = $this->common_data;
        return view($this->common_data['view'] . '.index', compact('data'));
    }

    public function get(Request $request)
    {
        $data = ExpenseMaster::select('*');

        if ($request->from && $request->to) {
            $from = date('Y-m-d',strtotime($request->from));
            $to = date('Y-m-d',strtotime($request->to));
            $data->whereBetween('transaction_date',[$from,$to]);
        }

        $data->orderBy('id','desc');

        return DataTables::eloquent($data)
            ->addIndexColumn()

            ->addColumn('action', function ($row) {
                $btn = "";
                $btn .= '<a href="' . route('edit_expense', encrypt($row['id'])) . '" class="btn shadow-primary waves-light btn-square btn-primary btn-sm mr-1"><i class="fa fa-pencil"></i></a>';
                $btn .= '<button data-id="' . $row['id'] . '"  class="delete_btn delete_record btn shadow-danger waves-light btn-square btn-danger btn-sm mr-1"><i class="fa fa-trash"></i></button>';

                return $btn;
            })

            ->addColumn('transaction_type',function($row) {
                return $row['transaction_type'] == 1 ? "<span class='badge badge-success'> Credit</span>" : "<span class='badge badge-danger'> Debit</span>";
            })

            ->addColumn('transaction_date',function($row) {
                return date('d-m-Y',strtotime($row->transaction_date));
            })

            ->rawColumns(['action','transaction_type'])
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
        ExpenseMaster::create([
            'name'             => $request->post('name'),
            'amount'           => $request->post('amount'),
            'transaction_type' => $request->post('transaction_type'),
            'description'      => $request->post('description'),
            'transaction_date' => date('Y-m-d', strtotime($request->post('transaction_date')))
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

    public function edit($id)
    {
        $data = $this->common_data;
        $expense = ExpenseMaster::find(decrypt($id));
        return view($this->common_data['view'] . '.edit', compact('data', 'expense'));
    }

    public function update(Request $request)
    {

        ExpenseMaster::find($request->id)->update([
            'name'             => $request->post('name'),
            'amount'           => $request->post('amount'),
            'transaction_type' => $request->post('transaction_type'),
            'description'      => $request->post('description'),
            'transaction_date' => date('Y-m-d', strtotime($request->post('transaction_date')))
        ]);


        Helper::message_popup($this->common_data['module'] . ' Successfully Updated.', 'success');
        return redirect('/' . $this->common_data['route']);
    }

    public function delete(Request $request)
    {
        $id = $request->post('id');
        $data = ExpenseMaster::find($id)->delete();
        Helper::message_popup($this->common_data['module'] . ' Successfully Deleted',  'success');
        return true;
    }

    public function expense_pdf(Request $request) {
        $data = ExpenseMaster::query();

        if ($request->from && $request->to) {
            $from = date('Y-m-d',strtotime($request->from));
            $to = date('Y-m-d',strtotime($request->to));
            $data->whereBetween('transaction_date',[$from,$to]);
        } else {
            $from = $data->pluck('transaction_date')->toArray()[0];
            $to = $data->orderBy('id','desc')->pluck('transaction_date')->toArray()[0];
        }

        $expenses = $data->get();

        //view('pdf.expense',compact('expenses','from','to'));
        $pdf = PDF::loadView('pdf.expense',compact('expenses','from','to'))->setPaper('a4')->setWarnings(false);
        return $pdf->stream();

    }
}
