<?php
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
Route::get("/lienhe", function(){
    return view('lienhe');
});

Route::post("/guilienhe", function(Illuminate\Http\Request $request){
    $arr = $request->post();
    $ht = trim(strip_tags($arr['ht']));
    $em = trim(strip_tags($arr['em']));
    $nd = trim(strip_tags($arr['nd']));
    $adminEmail = 'cucphan11665@gmail.com';
    Mail::mailer('smtp')->to($adminEmail)
        ->send(new App\Mail\GuiEmail($ht, $em, $nd));
    $request->session()->flash('thongbao', 'Đã gửi mail');
    return redirect("thongbao");
});

Route::get("/thongbao", function(Illuminate\Http\Request $request){
    $tb = $request->session()->get('thongbao');
    return view('thongbao', ['thongbao'=> $tb]);
});

Route::get('/', function () {
    return view('welcome');
});
