<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\UploadHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    const UPLOAD_DIR = 'uploads/news';

    public function index(\Illuminate\Http\Request $request)
    {
        $title = 'Danh sách Tin tức';
        $newsList = News::orderBy('id', 'DESC')->adminFilter(request())->paginate(request("per_page", 25))->withQueryString();
        return view('admin.news.index', compact('title', 'newsList'));
    }

    public function create()
    {
        $title = 'Thêm Tin tức mới';
        return view('admin.news.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:news,title',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'description' => 'required|string',
            'content' => 'required|string',
            'active' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['slug'] = Str::slug($request->title);
            $data['active'] = $request->boolean('active');

            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = UploadHelper::upload($request->file('thumbnail'), self::UPLOAD_DIR);
            }

            News::create($data);

            DB::commit();

            return redirect()->route('admin.news.index')->with('success', 'Thêm tin tức thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating news: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function edit(News $news)
    {
        $title = 'Chỉnh sửa Tin tức';
        return view('admin.news.edit', compact('title', 'news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:news,title,' . $news->id,
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'description' => 'required|string',
            'content' => 'required|string',
            'active' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['slug'] = Str::slug($request->title);
            $data['active'] = $request->boolean('active');

            if ($request->hasFile('thumbnail')) {
                if ($news->thumbnail) {
                    UploadHelper::deleteByUrl($news->thumbnail);
                }
                $data['thumbnail'] = UploadHelper::upload($request->file('thumbnail'), self::UPLOAD_DIR);
            }

            $news->update($data);

            DB::commit();

            return redirect()->route('admin.news.index')->with('success', 'Cập nhật tin tức thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating news: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy(News $news)
    {
        try {
            DB::beginTransaction();

            if ($news->thumbnail) {
                UploadHelper::deleteByUrl($news->thumbnail);
            }

            $news->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Xóa tin tức thành công!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting news: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}
