<?php

namespace App\Http\Controllers;

use App\Models\ClientModel;
use App\Models\ProductModel;
use App\Models\SubcategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    public function products(Request $request)
    {
        $params = $request->all();

        return (new ProductModel)
            ->activated()
            ->where(function ($query) use ($params) {
                if (isset($params['name'])) {
                    $query->where('name', 'LIKE', "{$params['name']}%");
                }

                if (isset($params['has']) && $params['has'] == 'orders') {
                    $query->has('orders');
                }
            })
            ->orderBy('name')
            ->select(['id', 'barcode', 'name', 'image', 'price'])
            ->get()
            ->each(function ($product) {
                $product->image = $product->image_show;
            });
    }

    public function subcategories(Request $request)
    {
        return (new SubcategoryModel)
            ->activated()
            ->where('category_id', $request->get('category_id'))
            ->orderBy('name')
            ->select(['id', 'name', 'active'])
            ->get();
    }

    public function autocomplete(Request $request, $type)
    {
        $term   = $request->get('term');
        $params = $request->all();
        $items  = [];

        if ($type == 'client') {
            $clients = (new ClientModel)
                ->activated()
                ->where('name', 'LIKE', "{$term}%")
                ->where(function ($query) use ($params) {
                    if (isset($params['has']) && $params['has'] == 'orders') {
                        $query->has('orders');
                    }
                })
                ->select(['id', 'name', 'cpf'])
                ->get();

            foreach ($clients as $client) {
                $items[] = [
                    'label' => $client->name . ' - ' . $client->cpf,
                    'value' => $client->id,
                ];
            }

            return response()->json($items);
        }

        if ($type == 'product') {
            $products = (new ProductModel)
                ->activated()
                ->where(function ($q) use ($term) {
                    $q->orWhere('barcode', 'LIKE', "{$term}%");
                    $q->orWhere('name', 'LIKE', "{$term}%");
                })
                ->where(function ($query) use ($params) {
                    if (isset($params['has']) && $params['has'] == 'orders') {
                        $query->has('orders');
                    }
                })
                ->select(['id', 'barcode', 'name', 'image', 'price'])
                ->get();

            foreach ($products as $product) {
                $items[] = [
                    'label'   => $product->barcode . ' - ' . $product->name,
                    'value'   => $product->id,
                    'product' => [
                        'id'    => $product->id,
                        'name'  => $product->name,
                        'image' => $product->image,
                        'price' => $product->price,
                    ],
                ];
            }

            return response()->json($items);
        }

        return response()->json($items);
    }

    public function upload(Request $request)
    {
        $this->validateByAjax($request, [
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $file      = $request->file('image');
        $extension = Str::lower($file->getClientOriginalExtension());
        $basename  = Str::lower($file->getClientOriginalName());
        $basename  = Str::slug(str_replace('.' . $extension, '', $basename));
        $filename  = "{$basename}.{$extension}";
        $directory = 'uploads/' . date('Ymd');
        $count     = 0;

        while (true) {
            $count++;

            $path = public_path("{$directory}/{$filename}");

            if (!file_exists($path)) {
                break;
            }

            $filename = "{$basename}-{$count}.{$extension}";
        }

        $file->move(public_path($directory), $filename);

        $path = "{$directory}/{$filename}";

        return response()->json([
            'status'  => 'success',
            'message' => 'Imagem enviada.',
            'path'    => $path,
            'url'     => url($path),
        ]);
    }
}