<?php

namespace App\Http\Controllers;

use App\DataTables\PelangganDataTable;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PelangganController extends Controller
{
    public function index(PelangganDataTable $table)
    {
        // Session::forget('data-pelanggan');
        return $table->render('Pelanggan.index');
    }
    public function create()
    {
        // $sessiondata = Session::get('data-pelanggan');
        // return view('Pelanggan.add', compact('sessiondata'));
        return view('Pelanggan.add');
    }
    public function update($id)
    {
        $data = Pelanggan::find($id);
        // $sessiondata = Session::get('data-pelanggan');
        // return view('Pelanggan.edit', compact('sessiondata'));
        return view('Pelanggan.edit',compact('data'));
    }
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            Pelanggan::find($id)->delete();
            DB::commit();
            return redirect()->route('customer.index')->with(['msg' => 'Berhasil Menghapus Pelanggan', 'type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return redirect()->route('customer.index')->with(['msg' => 'Gagal Menghapus Pelanggan', 'type' => 'danger']);
        }
    }
    public function processCreate(Request $request)
    {
        try {
        DB::beginTransaction();
        Pelanggan::create($request->all());
        DB::commit();
        return redirect()->route('customer.index')->with(['msg' => 'Berhasil Menambah Pelanggan', 'type' => 'success']);
        } catch (\Exception $e) {
        DB::rollBack();
        report($e);
        return redirect()->route('customer.index')->with(['msg' => 'Gagal Menambah Pelanggan', 'type' => 'danger']);
        }
    }
    public function processUpdate(Request $request)
    {
        try {
            DB::beginTransaction();
            Pelanggan::find($request->id)->update($request->except('id'));
            DB::commit();
            return redirect()->route('customer.index')->with(['msg' => 'Berhasil Mengupdate Pelanggan', 'type' => 'success']);
            } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return redirect()->route('customer.index')->with(['msg' => 'Gagal Mengupdate Pelanggan', 'type' => 'danger']);
            }
    }
    public function elemenAdd(Request $request)
    {
        $data = Session::get('data-pelanggan');
        $data[$request->name] = $request->value;
        Session::put('data-pelanggan', $data);
        return response(1);
    }
}
