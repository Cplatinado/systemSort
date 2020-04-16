<?php

namespace App\Http\Controllers\Admin;

use App\Email;
use App\Http\Controllers\Controller;
use App\Http\Requests\promocao;
use App\Mail\NewSort;
use App\PromoImage;
use App\Promotion;
use App\PromotionDo;
use App\Sorteio;
use App\SorteioDo;
use App\SortImage;
use App\suport\Crooper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prometions = Promotion::orderBy('id', 'desc')->paginate(12);
        $sortsCreate = Sorteio::all()->count();
        $sortsAvailable = Sorteio::Available()->count();
        $sortsUnavailable = Sorteio::Unavailable()->count();
        $sortFinalized = Sorteio::all()->where('finalized', 1)->count();

        $userSort = SorteioDo::all()->count();
        $userPromo = PromotionDo::all()->count();

        $promoCreate = Promotion::all()->count();
        $promofinalized = Promotion::all()->where('finalized', 1)->count();
        $promoAvailable = Promotion::Available()->count();

        return view('Admin.promocoes.index', [
            'prometions' => $prometions,
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
            'ativos' => 'home'

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(promocao $request)
    {

        $promotion = new Promotion();

        $promotion->date = $request->date;
        $promotion->description = $request->description;
        $promotion->title = $request->titulo;
        $promotion->save();
        $promotion->slug = Str::slug($request->title . $promotion->id);

        $promotion->save();


        if (!empty($request->file('cover'))) {

            $promotionImage = New PromoImage();
            $promotionImage->sort = $promotion->id;
            $promotionImage->path = $request->file('cover')->store('promo/' . $promotion->id);
            $promotionImage->cover = true;
            $promotionImage->save();


        }


        return redirect()->route('admin.promocoes.edit', ['promoco' => $promotion->id])
            ->with(['type' => 'success', 'message' => 'Promoção cadastrada com sucesso !']);
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
        $promotion = Promotion::find($id);

        $total = PromotionDo::where('id_promotion',$id)->count();
        $comfimed = PromotionDo::where('id_promotion',$id)->where('email_confirmed',1)->count();
        $nocomfirmed = PromotionDo::where('id_promotion',$id)->where('email_confirmed',0)->count();

        $usedcupom =PromotionDo::where('id_promotion',$id)->where('status_cupom',1)->count();
        $nousedcupom =PromotionDo::where('id_promotion',$id)->where('status_cupom',0)->count();

        return view('Admin.promocoes.edit', [
            'promo' => $promotion,
            'total'=>$total,
            'comfimed'=>$comfimed,
            'nocomfimerd'=>$nocomfirmed,
            'usecupom'=>$usedcupom,
            'nousecupom'=>$nousedcupom
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
        $promotion = Promotion::find($id);
        $promotion->title = $request->titulo;
        $promotion->status = $request->status;
        $promotion->date = $request->date;
        $promotion->description = $request->description;
        $promotion->headline = $request->headline;
        $promotion->call = $request->call;
        $promotion->save();
        if (!empty($request->allFiles()['files'])) {

            foreach ($request->allFiles()['files'] as $image) {
                $promoImage = New PromoImage();
                $promoImage->sort = $promotion->id;
                $promoImage->cover = 0;
                $promoImage->path = $image->store('sort/' . $promotion->id);
                $promoImage->save();
                unset($promoImage);
            }

//

        }

        return redirect()->route('admin.promocoes.edit', ['promoco' => $promotion->id])
            ->with(['type' => 'success', 'message' => 'Sorteio Alterado com sucesso !']);
    }

    public function validarCupom(Request $request)
    {
        $validate = PromotionDo::where('cupom', $request->codigo)->where('id_promotion', $request->id)->first();
        if ($validate) {

            if ($validate->status_cupom == 1) {
                return response()->json('Cupom Já Cadastrado !');
            }

            $validate->status_cupom = 1;
            $validate->save();

            return response()->json('Cupom Validado com sucesso !');

        } else {
            return response()->json('Cupom Invalido');
        }

    }

    public function imageDestroy(Request $request)
    {
        $image = PromoImage::find($request->image);
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
        $imageCover = PromoImage::find($request->image);
        $allImages = PromoImage::where('sort', $imageCover->sort)->get();


        foreach ($allImages as $image) {
            $image->cover = false;
            $image->save();
        }


        $imageCover->cover = true;
        $imageCover->save();
        $promotion = Promotion::find($image->sort);
        $promotion->cover = $imageCover->path;
        $promotion->save();


        $json = [
            'success' => true
        ];

        return response()->json($json);

    }


    public function ativos()
    {
        $promo = Promotion::Available()->paginate(12);
        $sortsCreate = Sorteio::all()->count();
        $sortsAvailable = Sorteio::Available()->count();
        $sortsUnavailable = Sorteio::Unavailable()->count();
        $sortFinalized = Sorteio::all()->where('finalized', 1)->count();

        $userSort = SorteioDo::all()->count();
        $userPromo = PromotionDo::all()->count();

        $promoCreate = Promotion::all()->count();
        $promofinalized = Promotion::all()->where('finalized', 1)->count();
        $promoAvailable = Promotion::Available()->count();



        return view('Admin.promocoes.index', [
            'prometions' => $promo,
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
            'ativos' => 'ativas',
        ]);
    }

    public function inativos()
    {
        $promo = Promotion::Unavailable()->paginate(12);
        $sortsCreate = Sorteio::all()->count();
        $sortsAvailable = Sorteio::Available()->count();
        $sortsUnavailable = Sorteio::Unavailable()->count();
        $sortFinalized = Sorteio::all()->where('finalized', 1)->count();

        $userSort = SorteioDo::all()->count();
        $userPromo = PromotionDo::all()->count();

        $promoCreate = Promotion::all()->count();
        $promofinalized = Promotion::all()->where('finalized', 1)->count();
        $promoAvailable = Promotion::Available()->count();


        return view('Admin.promocoes.index', [
            'prometions' => $promo,
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
            'ativos' => 'inativas',
        ]);
    }


    public function lancar($id)
    {
        $sorteio = Promotion::find($id);

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
