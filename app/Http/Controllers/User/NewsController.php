<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $title = 'Tin Tức - Cập Nhật Mới Nhất';
        $newsList = News::where('active', 1)
                        ->orderBy('created_at', 'desc')
                        ->paginate(12);
                        
        return view('user.news.index', compact('title', 'newsList'));
    }

    public function show($slug)
    {
        $news = News::where('slug', $slug)
                    ->where('active', 1)
                    ->firstOrFail();
                    
        // Increment views
        $news->increment('views');
        
        $title = $news->title;
        
        // Related news
        $relatedNews = News::where('active', 1)
                          ->where('id', '!=', $news->id)
                          ->orderBy('created_at', 'desc')
                          ->take(5)
                          ->get();
                          
        return view('user.news.show', compact('title', 'news', 'relatedNews'));
    }
}
