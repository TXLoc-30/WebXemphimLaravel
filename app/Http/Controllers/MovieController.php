<?php

namespace App\Http\Controllers;

use Auth;
use App\Cate;
use App\Link;
use App\Rate;
use App\User;
use App\Year;
use App\Image;
use App\Movie;
use App\Nation;
use App\Wallet;
use App\Comment;
use App\Payment;
use App\Language;
use Illuminate\Http\Request;
use App\Http\Requests\LinkRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\MovieRequest;
use Illuminate\Support\Facades\File;
use App\Http\Requests\EditMovieRequest;

class  MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function detailmovie($id)
    {
        $wallet = '';
        $payment = '';
        if (session('username_minmovies')) {
            $username = session('username_minmovies');
            $user = User::where('username', $username)->first();
            $user_id = $user->id;
            $wallet = Wallet::where('user_id', $user_id)->first();
            $payment = Payment::where('user_id', $user_id)->where('movie_id', $id)->first();
        } else {
            $user_id = 0;
        }
        
        $cate = Cate::all();
        $nation = Nation::all();
        $year = Year::all();
        $language = Language::all();
        $movie = Movie::find($id);
        
        if (!$movie) {
            return redirect()->route('user.index')->with(['thongbao_level' => 'danger', 'thongbao' => 'Phim không tồn tại!']);
        }
        
        $cate_id = $movie->cate_id;
        $slider = Movie::where('cate_id', $cate_id)->where('id', '!=', $id)->latest()->limit(10)->get();
        $comment = Comment::where('movie_id', $id)->get();
        $user = User::all();
        $rate = Rate::where('movie_id', $id)->get();
        
        if ($rate->isEmpty()) {
            $averageRate = 0;
            $totalRate = 0;
        } else {
            $totalRatePoint = 0;
            $totalRate = count($rate);
            foreach ($rate as $item) {
                $totalRatePoint += $item->rate;
            }
            $averageRate = number_format((float)($totalRatePoint / $totalRate), 1, '.', '');
        }

        return view('user.detailmovie', compact('slider', 'id', 'movie', 'cate', 'nation', 'year', 'language', 'user', 'comment', 'wallet', 'payment', 'user_id', 'averageRate', 'totalRate'));
    }
    public function watchmovie($id, $server)
    {
        $bought = 0;
        if (session('username_minmovies')) {
            $username = session('username_minmovies');
            $user = User::where('username', $username)->first();
            $user_id = $user->id;
            $wallet = Wallet::where('user_id', $user_id)->get();
            $payment = Payment::where('user_id', $user_id)->where('movie_id', $id)->get();
            if (!$payment->isEmpty()) {
                $bought = 1;
            }
        }
        $language = Language::all();
        $cate = Cate::all();
        $nation = Nation::all();
        $year = Year::all();
        $movie = Movie::find($id);
        $cate_id = $movie->cate_id;
        $suggest = Movie::latest()->limit(6)->get();
        $sliderCate = Movie::where('cate_id', $cate_id)->where('id', '!=', $id)->latest()->limit(10)->get();
        $slider = Movie::latest()->limit(10)->get();
        $link = Link::all();
        $comment = Comment::where('movie_id', $id)->get();
        $user = User::all();
        return view('user.watchmovie', compact('suggest', 'id', 'movie', 'cate', 'nation', 'year', 'link', 'server', 'slider', 'language', 'user', 'comment', 'sliderCate', 'bought'));
    }


    public function getlist()
    {
        $language = Language::all();
        $cate = Cate::all();
        $nation = Nation::all();
        $year = Year::all();
        $movie = Movie::latest()->paginate(24);
        return view('user.list', compact('movie', 'cate', 'nation', 'year', 'language'));
    }
    public function gettrailer()
    {
        $cate = Cate::all();
        $nation = Nation::all();
        $year = Year::all();
        $movie = Movie::latest()->paginate(24);
        return view('user.trailer', compact('movie', 'cate', 'nation', 'year'));
    }

    public function index()
    {
        //
        $movie = Movie::latest()->get();
        $cate = Cate::all();
        $nation = Nation::all();
        $year = Year::all();
        return view('admin.movie.list', compact('movie', 'cate', 'nation', 'year'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $cate = Cate::all();
        $nation = Nation::all();
        $year = Year::all();
        $language = Language::all();
        return view('admin.movie.add', compact(['cate', 'nation', 'year', 'language']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MovieRequest $request, LinkRequest $requestlink)
    {
        //
        $filename = $request->poster->getClientOriginalName();
        $movie = new Movie;
        $movie->vie_name = $request->txtViename;
        $movie->eng_name = $request->txtEngname;
        $movie->cate_id = $request->cate_id;
        $movie->nation_id = $request->nation_id;
        $movie->year_id = $request->year_id;
        $movie->language_id = $request->language_id;
        $movie->poster_image = $filename;
        $movie->information = $request->txtInfo;
        $movie->director = $request->txtDirector;
        $movie->point = $request->txtPoint;
        $movie->time = $request->txtTime . ' Phút';
        $movie->quality = $request->txtQuality;
        $movie->actor = $request->txtActor;
        $movie->trailer = $request->txtTrailer;
        $movie->eng_name = $request->txtEngname;
        $movie->price = $request->txtPrice;
        $movie->save();
        $request->poster->storeAs('poster', $filename);
        $link = new Link;
        $link->movie_id = $movie->id;
        $link->link1 = $requestlink->txtServer1;
        $link->link2 = $requestlink->txtServer2;
        $link->link3 = $requestlink->txtServer3;
        $link->link4 = $requestlink->txtServer4;
        $link->link5 = $requestlink->txtServer5;
        $link->link6 = $requestlink->txtServer6;
        $link->save();
        return redirect()->route('admin.movie.list')->with(['thongbao_level' => 'success', 'thongbao' => 'Thêm phim thành công!']);
    }

    public function postSearch(Request $request)
    {
        $language = Language::all();
        $cate = Cate::all();
        $nation = Nation::all();
        $year = Year::all();
        $search = $request->search;
        $searchSort = $request->searchSort;
        $movie = Movie::where('vie_name', 'like', '%' . $request->search . '%')->orWhere('eng_name', 'like', '%' . $request->search . '%')->latest()->paginate(24);
        return view('user.search', compact('cate', 'nation', 'year', 'movie', 'search', 'language', 'searchSort'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $movie = Movie::find($id);
        $cate = Cate::all();
        $nation = Nation::all();
        $year = Year::all();
        $language = Language::all();
        $link = Link::all();
        return view('admin.movie.edit', compact('movie', 'cate', 'nation', 'year', 'language', 'link', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(EditMovieRequest $request, LinkRequest $requestlink, $id)
    {
        //
        $movie = Movie::find($id);
        if ($request->poster) {
            $myFile = 'public/poster/' . $movie->poster_image;
            File::delete($myFile);
            $file = $request->file('poster');
            $originalFile = $file->getClientOriginalName();
            $filename = rand(1000, 9999) . '-' . $originalFile;
            $file->move('public/poster', $filename);
            $movie->poster_image = $filename;
        }
        $movie->vie_name = $request->txtViename;
        $movie->eng_name = $request->txtEngname;
        $movie->cate_id = $request->cate_id;
        $movie->nation_id = $request->nation_id;
        $movie->year_id = $request->year_id;
        $movie->language_id = $request->language_id;
        $movie->information = $request->txtInfo;
        $movie->director = $request->txtDirector;
        $movie->point = $request->txtPoint;
        $movie->time = $request->txtTime;
        $movie->quality = $request->txtQuality;
        $movie->actor = $request->txtActor;
        $movie->trailer = $request->txtTrailer;
        $movie->eng_name = $request->txtEngname;
        $movie->price = $request->txtPrice;
        $movie->save();
        $link = new Link;
        $arr['movie_id'] = $movie->id;
        $arr['link1'] = $requestlink->txtServer1;
        $arr['link2'] = $requestlink->txtServer2;
        $arr['link3'] = $requestlink->txtServer3;
        $arr['link4'] = $requestlink->txtServer4;
        $arr['link5'] = $requestlink->txtServer5;
        $arr['link6'] = $requestlink->txtServer6;
        $link::where('movie_id', $movie->id)->update($arr);
        return redirect()->route('admin.movie.list')->with(['thongbao_level' => 'success', 'thongbao' => 'Sửa phim thành công!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $movie = Movie::find($id);
        $movie->delete();
        return redirect()->route('admin.movie.list')->with(['thongbao_level' => 'success', 'thongbao' => 'Xoá phim thành công!']);
    }
    public function getBoughtMovie()
    {
        $cate = Cate::all();
        $nation = Nation::all();
        $year = Year::all();
        $language = Language::all();
        $username = session('username_minmovies');
        $user = User::where('username', $username)->first();
        $user_id = $user->id;
        $movie = Movie::all();
        $payment = Payment::where('user_id', $user_id)->paginate(24);
        return view('user.boughtMovie', compact('cate', 'nation', 'year', 'payment', 'movie', 'language'));
    }
    public  function getHint($q)
    {
        $hint = "";
        // Tim tat ca cac hint co trong Array neu tham so $q khac ""
        if ($q !== "") {
            $q = strtolower($q);
            $len = strlen($q);
            $movie = Movie::where('vie_name', 'like', '%' . $q . '%')->orWhere('eng_name', 'like', '%' . $q . '%')->get();
            foreach ($movie as $item) {
                if ($hint === "") {
                    $hint =  "<div class='searchHint'>
                    <a href='movie/detail/$item->id'>" . $item->vie_name . '</a></div>';
                } else {
                    $hint .= "<div class='searchHint'>
                    <a href='movie/detail/$item->id'>" . $item->vie_name . '</a></div>';
                }
            }
        }
        // Ket qua "Khong co suggestion nao" neu khong tim thay bat ky hint nao trong Array
        echo $hint === "" ? "Không tìm thấy phim!" : $hint;
    }
}
