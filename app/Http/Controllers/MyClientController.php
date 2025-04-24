<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use App\Models\MyClient;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\UpdateClientRequest;

class MyClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('clients.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request, ?string $oldImg = null)
    {
        try {
            $data = $request->validated();

            $data['slug'] = Str::slug($data['name']);

            if ($request->hasFile('client_logo')) {
                $logo = $request->file('client_logo');
                $logo->store('images', 'public');
                $data['client_logo'] = $logo->hashName();
            } else {
                $data['client_logo'] = 'no-image.jpg';
            }
            $client = MyClient::create($data);

            return response()->json([
                'title' => 'Success',
                'text' => 'Client created successfully',
                'icon' => 'success',
            ]);
        } catch (Exception $error) {
            return response()->json([
                'title' => 'Error',
                'text' => $error->getMessage(),
                'icon' => 'error'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $client = MyClient::where('id', $id)->firstOrFail();

        try {
            return response()->json([
                'data' => $client,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, string $id)
    {
        try {
            $data = $request->validated();

            $data['slug'] = Str::slug($data['name']);
            $client = MyClient::where('id', $id)->firstOrFail();

            if ($request->hasFile('client_logo')) {
                $logo = $request->file('client_logo');
                $logo->store('images', 'public');
                $data['client_logo'] = $logo->hashName();

                if (!empty($client->client_logo) && $client->client_logo != 'no-image.jpg') {
                    Storage::disk('public')->delete('images/' . $client->client_logo);
                }
            } else {
                $data['client_logo'] = 'no-image.jpg';
            }

            $client->update($data);

            return response()->json([
                'title' => 'Success',
                'text' => 'Client Updated successfully',
                'icon' => 'success',
            ]);
        } catch (Exception $error) {
            return response()->json([
                'title' => 'Error',
                'text' => $error->getMessage(),
                'icon' => 'error'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $client = MyClient::where('id', $id)->firstOrFail();

        if ($client->client_logo) {
            Storage::disk('public')->delete('images/' . $client->client_logo);
        }

        $client->delete();

        return response()->json([
            'title' => 'Success',
            'text' => 'Client deleted successfully',
            'icon' => 'success'
        ]);
    }

    public function getDataClients()
    {
        $client = MyClient::latest()->get();

        return DataTables::of($client)
            ->addIndexColumn()
            ->addColumn('client_logo', function ($row) {
                return '<div>
                          <img src="' . asset('storage/images/' . $row->client_logo) . '" class="img-fluid img-thumbnail" alt="' . $row->client_logo . '" style="width: 64px; height: 64px;object-fit: cover;">
                        </div>';
            })
            ->addColumn('action', function ($row) {
                return '<div>
                            <button class="btn btn-warning btn-sm edit" onclick="editModal(this)" data-id="' . $row->id . '"> <i class="fa-solid fa-pencil"></i></button>
                            <button class="btn btn-danger btn-sm hapus" onclick="deleteModal(this)" data-id="' . $row->id . '"> <i class="fa-solid fa-trash-can"></i></button>
                        </div>';
            })
            ->rawColumns(['client_logo', 'action'])
            ->make();
    }
}
