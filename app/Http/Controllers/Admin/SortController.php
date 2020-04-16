<?php

namespace App\Http\Controllers\Admin;

use App\Email;
use App\Http\Controllers\Controller;
use App\Mail\bistro;
use App\Mail\NewSort;
use App\Mail\SortWinner;
use App\Promotion;
use App\PromotionDo;
use App\Sorteio;
use App\SorteioDo;
use App\SortImage;
use App\suport\Crooper;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use function GuzzleHttp\Promise\queue;
use function MongoDB\BSON\toJSON;

class SortController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $sorts = Sorteio::orderBy('id', 'desc')->paginate(12);
        $sortsCreate = Sorteio::all()->count();
        $sortsAvailable = Sorteio::Available()->count();
        $sortsUnavailable = Sorteio::Unavailable()->count();
        $sortFinalized = Sorteio::all()->where('finalized', 1)->count();

        $userSort = SorteioDo::all()->count();
        $userPromo = PromotionDo::all()->count();

        $promoCreate = Promotion::all()->count();
        $promofinalized = Promotion::all()->where('finalized', 1)->count();
        $promoAvailable = Promotion::Available()->count();


//            dd($sortFinalized);

        return view('Admin.sorteios.index', [
            'sorts' => $sorts,
            'sortsFinalized' => $sortFinalized,
            'sortscreate' => $sortsCreate,
            'sortsavailable' => $sortsAvailable,
            'sortsunavaiable' => $sortsUnavailable,
            'usersort' => $sortsUnavailable,
            'sortsunavaiable' => $sortsUnavailable,
            'usersort' => $userSort,
            'userpromo' => $userPromo,
            'promocreate' => $promoCreate,
            'promofinalized' => $promofinalized,
            'promoavailable' => $promoAvailable,

            'ativos' => 'home',

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.sorteios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\Sorteio $request)
    {
        $sorteio = new Sorteio();
        $sorteio->date = $request->date;
        $sorteio->description = $request->description;
        $sorteio->save();
        $sorteio->title = $request->titulo;
        $sorteio->save();


        if (!empty($request->file('cover'))) {

            $sortImage = New SortImage();
            $sortImage->sort = $sorteio->id;
            $sortImage->path = $request->file('cover')->store('sort/' . $sorteio->id);
            $sortImage->cover = true;
            $sortImage->save();


        }


        return redirect()->route('admin.sorteios.edit', ['sorteio' => $sorteio->id])
            ->with(['type' => 'success', 'message' => 'Sorteio cadastrado com sucesso !']);


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sorteio = Sorteio::find($id);
        $users = SorteioDo::Avaliable()->where('id_sort', $id)->count();

        $userCreate = SorteioDo::all()->where('id_sort', $id)->count();
        $userConfirmed = SorteioDo::all()->where('id_sort', $id)->where('email_confirmed', 1)->count();
        $userNoConfirmed = SorteioDo::all()->where('id_sort', $id)->where('email_confirmed', 0)->count();


        return view('Admin.sorteios.edit', [
            'sorteio' => $sorteio,
            'usercreate' => $userCreate,
            'userconfimed' => $userConfirmed,
            'usernoconfimed' => $userNoConfirmed,
            'users' => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $sorteio = Sorteio::find($id);
        $sorteio->title = $request->titulo;
        $sorteio->status = $request->status;
        $sorteio->date = $request->date;
        $sorteio->description = $request->description;
        $sorteio->headline = $request->headline;
        $sorteio->call = $request->call;
        $sorteio->save();
        if (!empty($request->allFiles()['files'])) {

            foreach ($request->allFiles()['files'] as $image) {
                $sortImage = New SortImage();
                $sortImage->sort = $sorteio->id;
                $sortImage->path = $image->store('sort/' . $sorteio->id);
                $sortImage->save();
                unset($sortImage);
            }

//

        }

        return redirect()->route('admin.sorteios.edit', ['sorteio' => $sorteio->id])
            ->with(['type' => 'success', 'message' => 'Sorteio Alterado com sucesso !']);
    }

    public function sortear($id)
    {
        $list = SorteioDo::Avaliable()->where('id_sort', $id)->get(['id']);
        $list = json_decode($list, true);
        $json = SorteioDo::find(Arr::random($list));


        return response()->json($json);

    }


    public function imageDestroy(Request $request)
    {
        $image = SortImage::find($request->image);
        Storage::delete($image->path);
        Crooper::flush($image->path);
        $image->delete();

        $json = [
            'success' => true
        ];

        return response()->json($json);
    }

    public function imageCover(Request $request)
    {
        $imageCover = SortImage::find($request->image);
        $allImages = SortImage::where('sort', $imageCover->sort)->get();

//        dd($allImages);

        foreach ($allImages as $image) {
            $image->cover = false;
            $image->save();
        }


        $imageCover->cover = true;
        $imageCover->save();
        $sorteio = Sorteio::find($image->sort);
        $sorteio->cover = $imageCover->path;
        $sorteio->save();


        $json = [
            'success' => true
        ];

        return response()->json($json);

    }


    public function ativos()
    {
        $sort = Sorteio::Available()->paginate(12);
        $sortsCreate = Sorteio::all()->count();
        $sortsAvailable = Sorteio::Available()->count();
        $sortsUnavailable = Sorteio::Unavailable()->count();
        $sortFinalized = Sorteio::all()->where('finalized', 1)->count();

        $userSort = SorteioDo::all()->count();
        $userPromo = PromotionDo::all()->count();

        $promoCreate = Promotion::all()->count();
        $promofinalized = Promotion::all()->where('finalized', 1)->count();
        $promoAvailable = Promotion::Available()->count();


        return view('Admin.sorteios.index', [
            'sorts' => $sort,
            'ativos' => 'ativos',
            'sortsFinalized' => $sortFinalized,
            'sortscreate' => $sortsCreate,
            'sortsavailable' => $sortsAvailable,
            'sortsunavaiable' => $sortsUnavailable,
            'usersort' => $sortsUnavailable,
            'sortsunavaiable' => $sortsUnavailable,
            'usersort' => $userSort,
            'userpromo' => $userPromo,
            'promocreate' => $promoCreate,
            'promofinalized' => $promofinalized,
            'promoavailable' => $promoAvailable,
        ]);


    }

    public function inativos()
    {
        $sort = Sorteio::Unavailable()->paginate(12);
        $sortsCreate = Sorteio::all()->count();
        $sortsAvailable = Sorteio::Available()->count();
        $sortsUnavailable = Sorteio::Unavailable()->count();
        $sortFinalized = Sorteio::all()->where('finalized', 1)->count();

        $userSort = SorteioDo::all()->count();
        $userPromo = PromotionDo::all()->count();

        $promoCreate = Promotion::all()->count();
        $promofinalized = Promotion::all()->where('finalized', 1)->count();
        $promoAvailable = Promotion::Available()->count();

        return view('Admin.sorteios.index', [
            'sorts' => $sort,
            'ativos' => 'inativos',
            'sortsFinalized' => $sortFinalized,
            'sortscreate' => $sortsCreate,
            'sortsavailable' => $sortsAvailable,
            'sortsunavaiable' => $sortsUnavailable,
            'usersort' => $sortsUnavailable,
            'sortsunavaiable' => $sortsUnavailable,
            'usersort' => $userSort,
            'userpromo' => $userPromo,
            'promocreate' => $promoCreate,
            'promofinalized' => $promofinalized,
            'promoavailable' => $promoAvailable,
        ]);


    }

    public function finalizar(Request $request, $id)
    {
        $sort = Sorteio::find($id);
        //$sort->finalized = 1;
        $sort->status = 0;
        $sort->save();
        $data = [
            'reply_name' => $request->name,
            'reply_email' => $request->email,
            'sorteio' => $sort->title
        ];
        Mail::send(new SortWinner($data));


        return redirect()->route('admin.sorteios.edit', ['sorteio' => $id])
            ->with(['type' => 'success', 'message' => 'Sorteio Finalizado com sucesso !']);
    }

    public function lancar($id)
    {
        $sorteio = Sorteio::find($id);

        $listEmail = Email::all();
        $data = [
            'sorteio' => $sorteio->title,
            'link' => \route('web.sort', ['sorteio' => $sorteio->slug]),
            'call' => $sorteio->call,
        ];
        foreach ($listEmail as $email) {

            $data['reply_name'] = $email->name;
            $data['reply_email'] = $email->email;

            Mail::send(new NewSort($data));


        }


        return response()->json('enviado');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
