<?php

namespace App\Http\Controllers\Web;

use App\Email;
use App\Http\Controllers\Controller;
use App\Mail\bistro;
use App\Promotion;
use App\PromotionDo;
use App\Sorteio;
use App\SorteioDo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use phpDocumentor\Reflection\Types\Integer;

class webController extends Controller
{

    public function index()
    {
        $head = $this->Seo->render( 'Home'. ' - Bistrô da Saude',
            'Comer Saudáveljá tem lugar certo em foz',
            route('web.index'),
            'https://scontent.figu5-1.fna.fbcdn.net/v/t31.0-8/s960x960/19390686_1733162786976753_4862159998039158394_o.jpg?_nc_cat=103&_nc_sid=dd9801&_nc_eui2=AeFLT9oDz7a8YdfNuSvNvG209p8SXpz57GL2nxJenPnsYi_LnDif_hdWLfv-0Ty2wXZe5N5NdJkG5rMI5AXUSab4&_nc_ohc=lXAsPlm8S84AX_LcJNT&_nc_ht=scontent.figu5-1.fna&_nc_tp=7&oh=e6a8885ea005b02bc5159186aef2cf10&oe=5EB5C1D0');

        $sorts = Sorteio::Available()->where('finalized',0)->orderBy('id', 'desc')->take(4)->get();

        $promotion = Promotion::Available()->orderBy('id', 'desc')->take(4)->get();


        return view('web.index', [
            'sorteios' => $sorts,
            'promotions' => $promotion,
            'head'=>$head
        ]);
    }


    public function show($sorteio, Request $request)
    {

        $sort = Sorteio::where('slug', $sorteio)->first();
        $sort->views = $sort->views + 1;
        $sort->save();

        $head = $this->Seo->render( 'Sorteio'. ' - Bistrô da Saude',
            $sort->headline ?? $sort->title,
            route('web.sort',['sorteio'=>$sort->slug]),
            $sort->cover());

        return view('web.show', [
            'item' => $sort,
            'promotion' => false,
            'head'=>$head

        ]);
    }

    public function promotion($promotion)
    {


        $promotion = Promotion::where('slug', $promotion)->first();
        $promotion->views = $promotion->views + 1;
        $promotion->save();

        $head = $this->Seo->render( 'Promoção'. ' - Bistô da Saude',
            $promotion->headline ?? $promotion->title,
            route('web.promotion',['promocao'=>$promotion->slug]),
            $promotion->cover());

        return view('web.show', [
            'item' => $promotion,
            'promotion' => true,
            'head'=>$head

        ]);
    }

    public function sorteios()
    {
        $head = $this->Seo->render( 'Sorteios'. ' - Bistrô da Saude',
            'Comer Saudáveljá tem lugar certo em foz',
            route('web.index'),
            'https://scontent.figu5-1.fna.fbcdn.net/v/t31.0-8/s960x960/19390686_1733162786976753_4862159998039158394_o.jpg?_nc_cat=103&_nc_sid=dd9801&_nc_eui2=AeFLT9oDz7a8YdfNuSvNvG209p8SXpz57GL2nxJenPnsYi_LnDif_hdWLfv-0Ty2wXZe5N5NdJkG5rMI5AXUSab4&_nc_ohc=lXAsPlm8S84AX_LcJNT&_nc_ht=scontent.figu5-1.fna&_nc_tp=7&oh=e6a8885ea005b02bc5159186aef2cf10&oe=5EB5C1D0');

        $sorteios = Sorteio::where('finalized',0)->orderBy('id', 'desc')->paginate(12);


        return view('web.list', [
            'list' => $sorteios,
            'sorteio' => true
        ]);
    }

    public function sorteiosParticipar(Request $request)
    {

      $erros =  $this->validator($request->name, $request->email, $request->tel);

        if(SorteioDo::where('id_sort',$request->id)->where('email',$request->email)->first()){


            $json = ['errors'=>'E-mail já cadastrado'];
            return response()->json($json);

        }

      if(!empty($erros)){
            $json['errors'] = $erros;
          return response()->json($json);
      }

        $sorteio = new  SorteioDo();
        $sorteio->name = $request->name;
        $sorteio->tel = $request->tel;
        $sorteio->email = $request->email;
        $sorteio->id_sort = $request->id;
        $sorteio->hash = md5($request->id_sort . $request->email . now() . rand(0, 999));
        $sorteio->save();
        $link = 0;

        $data = [
            'reply_name' => $request->name,
            'reply_email' => $request->email,
            'tel' => $request->tel,
            'link' => route('web.Sortvalidator',['hash'=>$sorteio->hash])
        ];
        Mail::send(new bistro($data));
        $json['message'] = 'enviado';

        return response()->json($json);


    }

    public function promocoesParticipar(Request $request)
    {

        $erros =  $this->validator($request->name, $request->email, $request->tel);

        if(PromotionDo::where('id_promotion',$request->id)->where('email',$request->email)->first()){


            $json = ['errors'=>'E-mail já cadastrado'];
            return response()->json($json);

        }

        if(!empty($erros)){
            $json['errors'] = $erros;
            return response()->json($json);
        }

        $sorteio = new  PromotionDo();
        $sorteio->name = $request->name;
        $sorteio->tel = $request->tel;
        $sorteio->email = $request->email;
        $sorteio->id_promotion = $request->id;
        $sorteio->hash = md5($request->id . $request->email . now() . rand(0, 9999));
        $sorteio->cupom =  $request->id.rand(0, 99).date('s');
        $sorteio->save();


        $data = [
            'reply_name' => $request->name,
            'reply_email' => $request->email,
            'tel' => $request->tel,

            'link' => route('web.Promovalidator', ['hash' => $sorteio->hash])
        ];
//        \App\Jobs\bistro::dispatch($data);
        Mail::send(new bistro($data));
        $json['message'] = 'enviado';



        return response()->json($json);
    }

    public function Sortvalidator($hash)
    {
        $email = SorteioDo::where('hash', $hash)->first();
        $email->email_confirmed = true;
        $email->save();

        if(!Email::where('email',$email->email)->first()){
            $emailListAdd = New Email();
            $emailListAdd->name = $email->name;
            $emailListAdd->email = $email->email;
            $emailListAdd->save();
        }



        return view('web.e-mail-confirmed');

    }

    public function Promovalidator($hash)
    {
        $email = PromotionDo::where('hash', $hash)->first();

        $email->email_confirmed = true;
        $email->save();
        if(!Email::where('email',$email->email)->first()){
        $emailListAdd = New Email();
        $emailListAdd->name = $email->name;
        $emailListAdd->email = $email->email;
        $emailListAdd->save();
            }

       return view('Mail.promo-active',[
           'codigo'=>$email->cupom
       ]);
    }


    public function promocoes()
    {
        $promotion = Promotion::orderBy('id', 'desc')->paginate(12);


        return view('web.list', [
            'list' => $promotion,
            'sorteio' => false
        ]);
    }

    public function captura(Request $request)
    {
        if(Email::where('email',$request->email)->first()){
            return response()->json('error');
        }

        $captura = new Email();
        $captura->name = $request->name;
        $captura->email = $request->email;
        $captura->save();

        return response()->json('concluido');

    }


    private function validator($nome, $email, $tel)
    {$json = array();

        if(empty($nome)){
            $json[] = ['error'=>'Campo nome Requerido'];
        }else{
            if(strlen($nome) < 3){
                $json[] = ['error'=>'Campo nome Deve ter o minimo de 3 caracteres'];

            }
        }

        if(empty($email)){
            $json[] = ['error'=>'Campo E-mail Requerido'];
        }else{
            if(!filter_var($email, FILTER_VALIDATE_EMAIL) ){
                $json[] = ['error'=> 'Informe um e-mail Valido'];
            }
        }



        if(empty($tel)){
            $json[] = ['error'=>'Campo Telefone Requerido'];
        }



        return $json;

    }

}
