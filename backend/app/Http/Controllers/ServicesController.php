<?php

namespace App\Http\Controllers;

use App\Models\ServiceMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Notifications\MailNotification;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceMail  $serviceMail
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceMail $serviceMail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceMail  $serviceMail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceMail $serviceMail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceMail  $serviceMail
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceMail $serviceMail)
    {
        //
    }

    /**
     * Enviar notificación por correo electrónico
     *
     * @param  \App\Models\ServiceMail  $serviceMail
     * @return \Illuminate\Http\Response
     */
    public function notificacion_mail(Request $request)
    {
        if (Mail::to($request['para'])
        ->cc($request['cc'])
        ->send(new MailNotification($request)))
        {
            return response("Notificacion enviada exitosamente", 200);
        }
        else {
            return response("Ocurrio un error en el servidor", 500);
        }
        
    }
}
